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
                'stripe_subscription_id' => 'sub_1SAtLOAOSYhc3rrQr6JvIzX9',
                'price' => '29.90',
                'start_date' => '2025-09-24',
                'end_date' => '2025-10-24',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Subscription::insert($subscription);
    }
}
