<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create multiple companies
        foreach (range(1, 100) as $index) {
            Company::create([
                'name' => $faker->company,
                'email' => $faker->unique()->companyEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip_code' => $faker->postcode,
                'country' => $faker->country,
                'tax_id' => $faker->unique()->randomNumber(8),
                'website' => $faker->url,
                'is_active' => $faker->boolean,
            ]);
        }
    }
}
