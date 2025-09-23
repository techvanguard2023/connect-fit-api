<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTypeSeeder::class);
        $this->call(GoalSeeder::class);
        $this->call(PersonalSeeder::class);
        $this->call(NutritionistSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(FeaturePlanSeeder::class);
    }
}
