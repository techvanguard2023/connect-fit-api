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
                'name'        => 'Básico Free',
                'description' => 'Perfeito para quem está começando e quer experimentar de forma gratuita',
                'price'       => 0.00,
                'period'      => 'monthly',
                'is_free'     => true,
                'popular'     => false,
                'stripe_price_id' => 'price_1SKJq0AOSYhc3rrQJ7c38W0x',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Profissional',
                'description' => 'Para profissionais que querem crescer',
                'price'       => 29.90,
                'period'      => 'monthly',
                'is_free'     => false,
                'popular'     => true,
                'stripe_price_id' => 'price_1SKJs5AOSYhc3rrQmQqxr55f',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Premium',
                'description' => 'Para grandes profissionais',
                'price'       => 49.90,
                'period'      => 'monthly',
                'is_free'     => false,
                'popular'     => false,
                'stripe_price_id' => 'price_1SKJszAOSYhc3rrQwEcf6aSt',
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