<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Account;
use App\Models\User;
use App\Services\TaxCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_uses_tax_calculation_service_for_purchase_creation()
    {
        // Create a supplier with an account
        $supplier = Supplier::factory()->create();
        $account = Account::factory()->create(['supplier_id' => $supplier->id]);
        $supplier->account()->save($account);

        // Create a product
        $product = Product::factory()->create();

        // Mock the TaxCalculationService
        $mockTaxService = $this->mock(TaxCalculationService::class);
        $mockTaxService->shouldReceive('calculateProductTax')
            ->once()
            ->andReturn([
                'tax_amount' => 10.00,
                'tax_details' => [
                    [
                        'tax_type' => 'VAT',
                        'tax_rate' => 10.0,
                        'tax_amount' => 10.00
                    ]
                ]
            ]);

        $data = [
            'supplier_id' => $supplier->id,
            'purchase_date' => now()->format('Y-m-d'),
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'unit_price' => 50.00,
                    'discount_percent' => 0,
                    'tax_percent' => 10
                ]
            ]
        ];

        $response = $this->post(route('purchases.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('purchases', [
            'supplier_id' => $supplier->id,
            'total_amount' => 110.00 // 100 + 10 tax
        ]);
    }

    /** @test */
    public function it_handles_purchase_creation_without_tax_calculation_service()
    {
        // Create a supplier with an account
        $supplier = Supplier::factory()->create();
        $account = Account::factory()->create(['supplier_id' => $supplier->id]);
        $supplier->account()->save($account);

        // Create a product
        $product = Product::factory()->create();

        $data = [
            'supplier_id' => $supplier->id,
            'purchase_date' => now()->format('Y-m-d'),
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'unit_price' => 50.00,
                    'discount_percent' => 0,
                    'tax_percent' => 10
                ]
            ]
        ];

        $response = $this->post(route('purchases.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('purchases', [
            'supplier_id' => $supplier->id,
        ]);
    }
}
