<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $features = [
            [
                'name' => 'Até 20 alunos',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Criação de treinos básicos',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Acompanhamento de evolução',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Suporte por email',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Até 100 alunos',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Alunos ilimitados',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Treinos avançados e personalizados',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Planos de dieta completos',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Relatórios detalhados',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Suporte prioritário',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Suporte 24/7',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'IA para criação de treinos ou planos de dieta',
                'created_at' => $now, 'updated_at' => $now,
            ],
        ];

        // Evita duplicar: atualiza pela coluna 'name'
        DB::table('features')->upsert(
            $features,
            ['name'],
            ['updated_at']
        );
    }
}
