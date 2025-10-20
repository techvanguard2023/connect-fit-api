<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeaturePlanSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $map = [
            'Básico' => [
                'Até 1 alunos',
                'Criação de treinos ou dietas básicas',
                'Acompanhamento de evolução',
                'Suporte por email no horário comercial',
            ],
            'Profissional' => [
                'Até 10 alunos',
                'Treinos avançados e personalizados',
                'Planos de dieta completos',
                'Relatórios detalhados',
                'Conexão com WhatsApp',
                'Suporte por chat no horário comercial',
            ],
            'Premium' => [
                'Alunos ilimitados',
                'Treinos avançados e personalizados',
                'Planos de dieta completos',
                'Relatórios detalhados',
                'IA para criação de treinos ou planos de dieta',
                'Mensagens por Chat',
                'Conexão com WhatsApp',
                'Banner personalizável',
                'Suporte 24/7',
            ],
        ];

        // Busca IDs dos planos pelo nome
        $planIds = DB::table('plans')
            ->whereIn('name', array_keys($map))
            ->pluck('id', 'name'); // ['Básico' => 1, ...]

        // Busca IDs das features pelo nome (únicas no seu seeder)
        $allFeatureNames = collect($map)->flatten()->unique()->values()->all();
        $featureIds = DB::table('features')
            ->whereIn('name', $allFeatureNames)
            ->pluck('id', 'name'); // ['Até 20 alunos' => 1, ...]

        // Monta linhas do pivot
        $rows = [];
        foreach ($map as $planName => $features) {
            $planId = $planIds[$planName] ?? null;
            if (!$planId) {
                continue; // plano não encontrado
            }

            foreach ($features as $featureName) {
                $featureId = $featureIds[$featureName] ?? null;
                if (!$featureId) {
                    continue; // feature não encontrada
                }

                $rows[] = [
                    'plan_id'    => $planId,
                    'feature_id' => $featureId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (empty($rows)) {
            return;
        }

        // Remove vínculos antigos desses planos (evita lixo ao re-seedar)
        DB::table('feature_plans')->whereIn('plan_id', $planIds->values())->delete();

        // Insere vínculos
        DB::table('feature_plans')->insert($rows);
    }
}