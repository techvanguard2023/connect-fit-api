<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscription = [
            [
                'customer_id' => 5,
                'plan_id' => 1,
                'stripe_subscription_id' => 'sub_1SLOByAOSYhc3rrQZsf8PoXk',
                'price' => '0.00',
                'start_date' => '2025-10-23',
                'end_date' => '2025-11-23',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Subscription::insert($subscription);
    }
}
