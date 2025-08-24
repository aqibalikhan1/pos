<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition()
    {
        return [
            'company_name' => $this->faker->company,
            'contact_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'mobile' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'country' => 'Pakistan',
            'tax_number' => $this->faker->numerify('TIN-########'),
            'credit_limit' => $this->faker->randomFloat(2, 1000, 10000),
            'current_balance' => $this->faker->randomFloat(2, 0, 5000),
            'payment_terms' => $this->faker->randomElement(['Cash', '15 Days', '30 Days', '45 Days', '60 Days']),
            'supplier_type' => $this->faker->randomElement(['Manufacturer', 'Distributor', 'Wholesaler', 'Retailer', 'Importer']),
            'is_active' => true,
            'notes' => $this->faker->sentence,
        ];
    }
}
