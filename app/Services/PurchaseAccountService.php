<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\Supplier;
use Illuminate\Support\Str;

class PurchaseAccountService
{
    /**
     * Create account transaction for a purchase
     */
    public function createPurchaseTransaction(Purchase $purchase): AccountTransaction
    {
        $account = $purchase->account;
        $supplier = $purchase->supplier;

        $transactionNumber = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        
        $transaction = AccountTransaction::create([
            'transaction_number' => $transactionNumber,
            'account_id' => $account->id,
            'transaction_date' => $purchase->purchase_date,
            'transaction_type' => 'credit', // Credit for supplier (they owe us)
            'amount' => $purchase->total_amount,
            'balance_after' => $account->current_balance + $purchase->total_amount,
            'reference_type' => 'purchase',
            'reference_id' => $purchase->id,
            'payment_method' => 'credit',
            'description' => 'Purchase Order: ' . $purchase->purchase_number . ' - ' . $supplier->company_name,
            'created_by' => auth()->id(),
        ]);

        // Update account balance
        $account->current_balance += $purchase->total_amount;
        $account->save();

        return $transaction;
    }

    /**
     * Reverse a purchase transaction (for cancellations or returns)
     */
    public function reversePurchaseTransaction(Purchase $purchase): AccountTransaction
    {
        $account = $purchase->account;
        $supplier = $purchase->supplier;

        $transactionNumber = 'TRX-REV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        
        $transaction = AccountTransaction::create([
            'transaction_number' => $transactionNumber,
            'account_id' => $account->id,
            'transaction_date' => now(),
            'transaction_type' => 'debit', // Debit to reverse the credit
            'amount' => $purchase->total_amount,
            'balance_after' => $account->current_balance - $purchase->total_amount,
            'reference_type' => 'purchase_reversal',
            'reference_id' => $purchase->id,
            'payment_method' => 'credit',
            'description' => 'Purchase Reversal: ' . $purchase->purchase_number . ' - ' . $supplier->company_name,
            'created_by' => auth()->id(),
        ]);

        // Update account balance
        $account->current_balance -= $purchase->total_amount;
        $account->save();

        return $transaction;
    }

    /**
     * Create account for a supplier if it doesn't exist
     */
    public function createSupplierAccount(Supplier $supplier): Account
    {
        // Generate account number
        $accountNumber = 'SUP-' . strtoupper(Str::random(8));
        
        $account = Account::create([
            'account_number' => $accountNumber,
            'account_type' => 'supplier',
            'account_name' => $supplier->company_name,
            'contact_person' => $supplier->contact_person,
            'phone' => $supplier->phone,
            'email' => $supplier->email,
            'address' => $supplier->address,
            'current_balance' => 0,
            'credit_limit' => 100000, // Default credit limit
            'payment_terms' => 'net_30',
            'is_active' => true,
            'opening_balance' => 0,
            'opening_balance_date' => now(),
        ]);

        // Link account to supplier
        $supplier->account_id = $account->id;
        $supplier->save();

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
     * Process payment against a purchase
     */
    public function processPayment(Purchase $purchase, float $amount, string $paymentMethod): AccountTransaction
    {
        $account = $purchase->account;
        $supplier = $purchase->supplier;

        $transactionNumber = 'TRX-PAY-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        
        $transaction = AccountTransaction::create([
            'transaction_number' => $transactionNumber,
            'account_id' => $account->id,
            'transaction_date' => now(),
            'transaction_type' => 'debit', // Debit for payment (reducing what they owe)
            'amount' => $amount,
            'balance_after' => $account->current_balance - $amount,
            'reference_type' => 'payment',
            'reference_id' => $purchase->id,
            'payment_method' => $paymentMethod,
            'description' => 'Payment for Purchase: ' . $purchase->purchase_number . ' - ' . $supplier->company_name,
            'created_by' => auth()->id(),
        ]);

        // Update account balance
        $account->current_balance -= $amount;
        $account->save();

        // Update purchase payment status
        $this->updatePurchasePaymentStatus($purchase);

        return $transaction;
    }

    /**
     * Update purchase payment status based on account balance
     */
    protected function updatePurchasePaymentStatus(Purchase $purchase): void
    {
        $account = $purchase->account;
        $outstandingAmount = $purchase->total_amount - $this->getPaidAmount($purchase);

        if ($outstandingAmount <= 0) {
            $purchase->payment_status = 'paid';
        } elseif ($outstandingAmount < $purchase->total_amount) {
            $purchase->payment_status = 'partial';
        } else {
            $purchase->payment_status = 'pending';
        }

        $purchase->save();
    }

    /**
     * Get total paid amount for a purchase
     */
    protected function getPaidAmount(Purchase $purchase): float
    {
        return AccountTransaction::where('account_id', $purchase->account_id)
            ->where('reference_type', 'payment')
            ->where('reference_id', $purchase->id)
            ->sum('amount');
    }
}
