<?php
// database/seeders/RoleSeeder.php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $items = [
            [
                'title' => 'JECTRAN PREMIUM W/ ZINC SOLUTION FOR INJECTION 20 ML INJ 1 VIA SS PH',
                'description' => 'JECTRAN PREMIUM W/ ZINC SOLUTION FOR INJECTION 20 ML INJ 1 VIA SS PH',
                'sku_code' => '107497',
                'price' => '258.92',
                'price_adjustment' => '0',
                'del_flag' => 1,
                'user_id' => 1,
            ],
            [
                'title' => 'VETRACIN GOLD WITH PROBIOTICS 48 X 5 G PDR 1 BOX SS PH',
                'description' => 'VETRACIN GOLD WITH PROBIOTICS 48 X 5 G PDR 1 BOX SS PH',
                'sku_code' => '401337',
                'price' => '8923.58',
                'price_adjustment' => '0',
                'del_flag' => 1,
                'user_id' => 2,
            ],
            [
                'title' => 'ETRACIN GOLD WITH PROBIOTICS 1 KG PDR 1 CAN SS PH',
                'description' => 'ETRACIN GOLD WITH PROBIOTICS 1 KG PDR 1 CAN SS PH',
                'sku_code' => '401380',
                'price' => '1696.40',
                'price_adjustment' => '0',
                'del_flag' => 1,
                'user_id' => 2,
            ],
            [
                'title' => 'SUSTALIN LA SOLUTION FOR INJECTION 10 ML INJ 1 VIA SS PH',
                'description' => 'SUSTALIN LA SOLUTION FOR INJECTION 10 ML INJ 1 VIA SS PH',
                'sku_code' => '400621',
                'price' => '142.85',
                'price_adjustment' => '0',
                'del_flag' => 1,
                'user_id' => 1,
            ],
        ];

        foreach ($items as $item) {
            Product::firstOrCreate(
                ['sku_code' => $item['sku_code']],
                $item
            );
        }

        $this->command->info('Products seeded successfully!');
    }
}