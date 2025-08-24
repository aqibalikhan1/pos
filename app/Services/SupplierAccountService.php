<?php

namespace App\Services;

use App\Models\SupplierPayment;
use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SupplierAccountService
{
    /**
     * Create account transaction for a supplier payment
     */
    public function createSupplierPaymentTransaction(SupplierPayment $supplierPayment): AccountTransaction
    {
        $supplier = $supplierPayment->supplier;
        
        // Get or create supplier account
        $account = $this->getOrCreateSupplierAccount($supplier);

        $transactionNumber = 'TRX-SUP-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        
        $transaction = AccountTransaction::create([
            'transaction_number' => $transactionNumber,
            'account_id' => $account->id,
            'transaction_date' => $supplierPayment->payment_date,
            'transaction_type' => 'debit', // Debit for supplier payment (reducing what they owe)
            'amount' => $supplierPayment->amount,
            'balance_after' => $account->current_balance - $supplierPayment->amount,
            'reference_type' => 'supplier_payment',
            'reference_id' => $supplierPayment->id,
            'payment_method' => $supplierPayment->payment_method,
            'cheque_number' => $supplierPayment->reference_number,
            'cheque_date' => $supplierPayment->payment_date,
            'description' => 'Supplier Payment: ' . $supplierPayment->payment_number . ' - ' . $supplier->company_name,
            'created_by' => $supplierPayment->created_by,
        ]);

        // Update account balance
        $account->current_balance -= $supplierPayment->amount;
        $account->save();

        return $transaction;
    }

    /**
     * Reverse a supplier payment transaction (for cancellations or returns)
     */
    public function reverseSupplierPaymentTransaction(SupplierPayment $supplierPayment): AccountTransaction
    {
        $supplier = $supplierPayment->supplier;
        $account = $supplier->account;

        if (!$account) {
            throw new \Exception('Supplier account not found');
        }

        $transactionNumber = 'TRX-REV-SUP-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        
        $transaction = AccountTransaction::create([
            'transaction_number' => $transactionNumber,
            'account_id' => $account->id,
            'transaction_date' => now(),
            'transaction_type' => 'credit', // Credit to reverse the debit
            'amount' => $supplierPayment->amount,
            'balance_after' => $account->current_balance + $supplierPayment->amount,
            'reference_type' => 'supplier_payment_reversal',
            'reference_id' => $supplierPayment->id,
            'payment_method' => $supplierPayment->payment_method,
            'description' => 'Supplier Payment Reversal: ' . $supplierPayment->payment_number . ' - ' . $supplier->company_name,
            'created_by' => auth()->id(),
        ]);

        // Update account balance
        $account->current_balance += $supplierPayment->amount;
        $account->save();

        return $transaction;
    }

    /**
     * Get or create account for a supplier
     */
    public function getOrCreateSupplierAccount(Supplier $supplier): Account
    {
        if ($supplier->account) {
            return $supplier->account;
        }

        // Generate account number
        $accountNumber = 'SUP-' . strtoupper(Str::random(8));
        
        $account = Account::create([
            'account_number' => $accountNumber,
            'account_type' => 'supplier',
            'account_name' => $supplier->company_name,
            'accountable_id' => $supplier->id,
            'accountable_type' => Supplier::class,
            'contact_person' => $supplier->contact_name,
            'phone' => $supplier->phone,
            'email' => $supplier->email,
            'address' => $supplier->address,
            'current_balance' => 0,
            'credit_limit' => $supplier->credit_limit ?? 100000,
            'payment_terms' => $supplier->payment_terms ?? 'net_30',
            'is_active' => true,
            'opening_balance' => 0,
            'opening_balance_date' => now(),
            'created_by' => auth()->id(),
        ]);

        return $account;
    }

    /**
     * Get account balance for a supplier
     */
    public function getSupplierBalance(Supplier $supplier): float
    {
        if (!$supplier->account) {
            return 0;
        }

        return $supplier->account->current_balance;
    }

    /**
     * Check if supplier has sufficient credit limit
     */
    public function checkCreditLimit(Supplier $supplier, float $amount): bool
    {
        if (!$supplier->account) {
            return false;
        }

        $availableCredit = $supplier->account->credit_limit - $supplier->account->current_balance;
        return $amount <= $availableCredit;
    }

    /**
     * Process payment against supplier account (general payment not tied to specific purchase)
     */
    public function processGeneralPayment(Supplier $supplier, float $amount, string $paymentMethod, string $referenceNumber = null): AccountTransaction
    {
        $account = $this->getOrCreateSupplierAccount($supplier);

        $transactionNumber = 'TRX-GEN-SUP-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        
        $transaction = AccountTransaction::create([
            'transaction_number' => $transactionNumber,
            'account_id' => $account->id,
            'transaction_date' => now(),
            'transaction_type' => 'debit', // Debit for payment (reducing what they owe)
            'amount' => $amount,
            'balance_after' => $account->current_balance - $amount,
            'reference_type' => 'general_payment',
            'reference_id' => null,
            'payment_method' => $paymentMethod,
            'cheque_number' => $referenceNumber,
            'description' => 'General Payment to Supplier: ' . $supplier->company_name,
            'created_by' => auth()->id(),
        ]);

        // Update account balance
        $account->current_balance -= $amount;
        $account->save();

        return $transaction;
    }
}
