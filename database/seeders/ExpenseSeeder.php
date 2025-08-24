<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expense;
use Faker\Factory as Faker;
use App\Models\Category;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->info('No categories found, creating some first.');
            Category::factory()->count(10)->create();
            $categories = Category::all();
        }

        for ($i = 0; $i < 100; $i++) {
            Expense::create([
                'category_id' => $categories->random()->id, // Assuming you have 10 categories
                'description' => $faker->sentence,
                'amount' => $faker->randomFloat(2, 1, 1000), // Amount between 1 and 1000
                'expense_date' => $faker->date(),
                'receipt_number' => $faker->optional()->word,
                'notes' => $faker->optional()->paragraph,
                'is_recurring' => $faker->boolean,
                'recurring_frequency' => $faker->optional()->randomElement(['daily', 'weekly', 'monthly', 'yearly']),
            ]);
        }
    }
}
