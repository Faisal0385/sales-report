<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert 30 dummy sales records
        for ($i = 0; $i < 30; $i++) {

            // Random sales amounts
            $cashSales = $faker->randomFloat(2, 50, 1000);
            $techpointSales = $faker->randomFloat(2, 50, 1000);
            $tiktechSales = $faker->randomFloat(2, 50, 1000);
            $cardSales = $faker->randomFloat(2, 50, 1000);
            $printExpressSales = $faker->randomFloat(2, 50, 1000);

            $dailyTotal = $cashSales + $techpointSales + $tiktechSales + $cardSales + $printExpressSales;

            DB::table('sales')->insert([
                'sales_date' => $faker->date(),
                'day' => date('d', strtotime($faker->date())),
                'month' => date('m', strtotime($faker->date())),
                'year' => date('Y', strtotime($faker->date())),

                'cash_sales' => $cashSales,
                'techpoint_sales' => $techpointSales,
                'tiktech_sales' => $tiktechSales,
                'card_sales' => $cardSales,
                'print_express_sales' => $printExpressSales,

                'daily_total' => $dailyTotal,
                'company' => $faker->randomElement(['TechPoint', 'TikTech', 'PrintExpress']),
                'branch' => $faker->city,

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
