<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PersonalTrainerInfo;

class PersonalTrainerInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PersonalTrainerInfo::create([
            'customer_id' => 5,
            'certifications' => ['Certificação Personal Trainer', 'Certificação em Nutrição'],
            'experience_years' => 5,
        ]);
    }
}
