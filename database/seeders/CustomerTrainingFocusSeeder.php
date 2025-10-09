<?php

namespace Database\Seeders;

use App\Models\CustomerTrainingFocus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerTrainingFocusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerTrainingFocus::create([
            'customer_id' => 5,
            'training_focus_id' => 1,
        ]);

        CustomerTrainingFocus::create([
            'customer_id' => 5,
            'training_focus_id' => 2,
        ]);

        CustomerTrainingFocus::create([
            'customer_id' => 5,
            'training_focus_id' => 3,
        ]);
    }
}
