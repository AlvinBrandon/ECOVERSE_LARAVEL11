<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EcoReward;

class EcoRewardSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $rewards = [
            [
                'name' => '5% Discount Voucher',
                'description' => 'Get 5% off your next eco-friendly purchase',
                'points_required' => 500,
                'type' => 'discount_percentage',
                'value' => 5,
                'stock' => -1, // Unlimited
                'conditions' => ['minimum_order_value' => 50]
            ],
            [
                'name' => '10% Discount Voucher',
                'description' => 'Get 10% off your next eco-friendly purchase',
                'points_required' => 1000,
                'type' => 'discount_percentage',
                'value' => 10,
                'stock' => -1,
                'conditions' => ['minimum_order_value' => 100]
            ],
            [
                'name' => '$10 Off Voucher',
                'description' => 'Get $10 off your next purchase',
                'points_required' => 1500,
                'type' => 'discount_fixed',
                'value' => 10,
                'stock' => -1,
                'conditions' => ['minimum_order_value' => 50]
            ],
            [
                'name' => 'Free Shipping',
                'description' => 'Free shipping on your next order',
                'points_required' => 300,
                'type' => 'free_shipping',
                'value' => 0,
                'stock' => -1,
                'conditions' => ['minimum_order_value' => 25]
            ],
            [
                'name' => '15% Eco-Friendly Special',
                'description' => 'Special 15% discount for eco-conscious members',
                'points_required' => 2000,
                'type' => 'discount_percentage',
                'value' => 15,
                'stock' => -1,
                'conditions' => ['minimum_order_value' => 150]
            ],
            [
                'name' => '$25 Premium Voucher',
                'description' => 'Premium voucher for dedicated eco-warriors',
                'points_required' => 3000,
                'type' => 'discount_fixed',
                'value' => 25,
                'stock' => -1,
                'conditions' => ['minimum_order_value' => 100]
            ]
        ];

        foreach ($rewards as $reward) {
            EcoReward::create($reward);
        }
    }
}
