<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NutritionSpecialtiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            'Nutrição Esportiva',
            'Nutrição Funcional',
            'Nutrição Clínica',
            'Nutrição Estética',
            'Nutrição para Emagrecimento',
            'Nutrição para Ganho de Massa',
            'Nutrição Vegana/Vegetariana',
            'Nutrição Geriátrica',
            'Nutrição Comportamental',
            'Nutrição para Doenças Crônicas',
            'Nutrição Ortomolecular',
            'Nutrição Oncológica',
            'Nutrição Endocrinológica',
            'Nutrição Renal',
            'Nutrição Gastrointestinal',
        ];

        foreach ($specialties as $name) {
            DB::table('nutrition_specialties')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
