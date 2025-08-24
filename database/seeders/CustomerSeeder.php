<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 sample customers using the factory
        Customer::factory()->count(50)->create();

        // Create some specific customers for testing
        Customer::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+1-555-123-4567',
            'address' => '123 Main Street',
            'is_active' => true,
            'is_filer' => true,
            'cnic' => '1234512345678',
            'tax_number' => '12345678901',
            'notes' => 'Regular customer, always pays on time',
        ]);

        Customer::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'phone' => '+1-555-987-6543',
            'is_active' => true,
            'is_filer' => false,
            'cnic' => '9876598765432',
            'tax_number' => '98765432109',
            'notes' => 'New customer, first purchase last month',
        ]);

        Customer::factory()->create([
            'first_name' => 'Muhammad',
            'last_name' => 'Ahmed',
            'email' => 'muhammad.ahmed@example.com',
            'phone' => '+92-300-1234567',          
            'is_active' => true,
            'is_filer' => true,
            'cnic' => '3520212345678',
            'tax_number' => '12345678901',
            'notes' => 'Corporate client, bulk orders',
        ]);

        $this->command->info('53 customers seeded successfully!');
    }
}
