<?php
namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];

        // Create sample routes for each day
        foreach ($days as $dayNumber => $dayName) {
            Route::create([
                'name' => "Morning Route - {$dayName}",
                'description' => "Regular morning delivery route for {$dayName}",
                'day_of_week' => $dayNumber,
                'is_active' => true,
            ]);

            Route::create([
                'name' => "Afternoon Route - {$dayName}",
                'description' => "Regular afternoon delivery route for {$dayName}",
                'day_of_week' => $dayNumber,
                'is_active' => true,
            ]);
        }
    }
}
