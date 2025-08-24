<?php

namespace Database\Seeders;

use App\Models\Town;
use Illuminate\Database\Seeder;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $towns = [
            ['name' => 'Karachi', 'status' => true],
            ['name' => 'Lahore', 'status' => true],
            ['name' => 'Islamabad', 'status' => true],
            ['name' => 'Rawalpindi', 'status' => true],
            ['name' => 'Faisalabad', 'status' => true],
            ['name' => 'Multan', 'status' => true],
            ['name' => 'Peshawar', 'status' => true],
            ['name' => 'Quetta', 'status' => true],
            ['name' => 'Hyderabad', 'status' => true],
            ['name' => 'Gujranwala', 'status' => true],
        ];

        foreach ($towns as $town) {
            Town::create($town);
        }

        // Create additional random towns
        Town::factory(10)->create();
    }
}
