<?php

namespace Database\Seeders;

use App\Models\Goal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goals = [
            ['name' => 'Perda de Peso', 'description' => 'Foco em emagrecimento e definição muscular'],
            ['name' => 'Ganho de Massa Muscular', 'description' => 'Hipertrofia muscular com treinos intensos e alimentação adequada'],
            ['name' => 'Definição Muscular', 'description' => 'Redução de gordura corporal mantendo a massa magra'],
            ['name' => 'Melhora do Condicionamento Físico', 'description' => 'Aumento da resistência cardiovascular e respiratória'],
            ['name' => 'Reabilitação Física', 'description' => 'Recuperação de lesões com acompanhamento adequado'],
            ['name' => 'Saúde e Bem-estar', 'description' => 'Exercícios voltados à qualidade de vida e saúde geral'],
            ['name' => 'Preparação para Concursos', 'description' => 'Treinos focados em provas físicas de concursos (PM, Bombeiro, etc.)'],
            ['name' => 'Melhorar Mobilidade e Flexibilidade', 'description' => 'Foco em alongamentos e mobilidade articular'],
            ['name' => 'Reduzir Estresse e Ansiedade', 'description' => 'Atividades com foco em saúde mental, como yoga e pilates'],
            ['name' => 'Manutenção do Corpo', 'description' => 'Objetivo de manter o peso e a rotina saudável já conquistada'],
        ];

        foreach ($goals as $goal) {
            Goal::create($goal);
        }
    }
}
