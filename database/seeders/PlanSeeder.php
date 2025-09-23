<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $plans = [
            [
                'name'        => 'Básico',
                'description' => 'Perfeito para personal trainers iniciantes',
                'price'       => 29.90,
                'period'      => 'monthly',
                'popular'     => false,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Profissional',
                'description' => 'Para profissionais que querem crescer',
                'price'       => 49.90,
                'period'      => 'monthly',
                'popular'     => true,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Premium',
                'description' => 'Para academias e grandes profissionais',
                'price'       => 99.90,
                'period'      => 'monthly',
                'popular'     => false,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        // Evita duplicar ao rodar mais de uma vez
        $names = collect($plans)->pluck('name')->all();
        DB::table('plans')->whereIn('name', $names)->delete();

        DB::table('plans')->insert($plans);
    }
}