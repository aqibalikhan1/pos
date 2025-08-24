<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Product;
use App\Models\TaxRate;

class TaxCalculationService
{
    /**
     * Calculate tax for a product based on transaction type and customer filer status
     *
     * @param Product $product
     * @param string $transactionType 'sale' or 'purchase'
     * @param Customer|null $customer (for sales transactions)
     * @param float $quantity
     * @param float $unitPrice
     * @param float $discountAmount
     * @return array
     */
    public function calculateProductTax(Product $product, string $transactionType, ?Customer $customer = null, float $quantity, float $unitPrice, float $discountAmount = 0): array
    {
        $taxableAmount = ($quantity * $unitPrice) - $discountAmount;
        $taxAmount = 0;
        $taxDetails = [];

        // Get applicable tax rates based on transaction type and customer filer status
        $applicableTaxRates = $this->getApplicableTaxRates($product, $transactionType, $customer);

        foreach ($applicableTaxRates as $taxRate) {
            $rateTaxAmount = $this->calculateTaxAmount($taxableAmount, $taxRate);
            $taxAmount += $rateTaxAmount;
            
            $taxDetails[] = [
                'tax_rate_id' => $taxRate->id,
                'tax_rate_name' => $taxRate->name,
                'tax_rate' => $taxRate->rate,
                'tax_amount' => $rateTaxAmount,
                'is_percentage' => $taxRate->taxType->type === 'percentage',
                'transaction_type' => $transactionType,
            ];
        }

        return [
            'tax_amount' => $taxAmount,
            'tax_details' => $taxDetails,
            'taxable_amount' => $taxableAmount,
        ];
    }

    /**
     * Get applicable tax rates for a product based on transaction type and customer filer status
     *
     * @param Product $product
     * @param string $transactionType 'sale' or 'purchase'
     * @param Customer|null $customer (for sales transactions)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getApplicableTaxRates(Product $product, string $transactionType, ?Customer $customer = null)
    {
        $productTaxRates = $product->taxRates()->with('taxType')->get();

        // Filter tax rates based on transaction type from product tax mappings
        return $productTaxRates->filter(function ($taxRate) use ($transactionType, $customer) {
            // Get the pivot data (product tax mapping)
            $pivot = $taxRate->pivot;
            
            // Filter by transaction type from product tax mapping
            if (!in_array($pivot->transaction_type, ['both', $transactionType])) {
                return false;
            }

            // For sales transactions, apply customer-specific filtering
            if ($transactionType === 'sale' && $customer) {
                $taxType = $taxRate->taxType;
                if ($customer->is_filer) {
                    // For tax filers, apply reduced rates or specific tax types
                    return $taxType->code === 'REDUCED' || $taxType->code === 'ZERO';
                } else {
                    // For non-filers, apply standard tax rates
                    return $taxType->code === 'STANDARD' || $taxType->code === 'GENERAL';
                }
            }

            // For purchase transactions, apply all applicable rates
            return true;
        });
    }

    /**
     * Calculate tax amount based on tax rate type
     *
     * @param float $taxableAmount
     * @param TaxRate $taxRate
     * @return float
     */
    protected function calculateTaxAmount(float $taxableAmount, TaxRate $taxRate): float
    {
        if ($taxRate->taxType->type === 'percentage') {
            return $taxableAmount * ($taxRate->rate / 100);
        } else {
            return $taxRate->fixed_amount;
        }
    }

    /**
     * Get default tax rates for non-filers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDefaultTaxRates()
    {
        return TaxRate::active()
            ->whereHas('taxType', function ($query) {
                $query->where('code', 'STANDARD')
                      ->orWhere('code', 'GENERAL');
            })
            ->get();
    }

    /**
     * Get reduced tax rates for filers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFilerTaxRates()
    {
        return TaxRate::active()
            ->whereHas('taxType', function ($query) {
                $query->where('code', 'REDUCED')
                      ->orWhere('code', 'ZERO');
            })
            ->get();
    }
}
