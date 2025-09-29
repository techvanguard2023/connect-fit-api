<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingFocusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $focuses = [
            'Hipertrofia',
            'Emagrecimento',
            'Condicionamento Físico',
            'Funcional',
            'Força',
            'Resistência Muscular',
            'Mobilidade / Flexibilidade',
            'Reabilitação / Pós-lesão',
            'Performance Esportiva',
            'Treinamento para Iniciantes',
            'Treino em Casa',
            'Treinamento para Idosos',
            'Treinamento com Peso Corporal',
            'HIIT',
            'Alongamento / Relaxamento',
        ];

        foreach ($focuses as $name) {
            DB::table('training_focuses')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
