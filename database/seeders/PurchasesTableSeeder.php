<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert 20 dummy purchases
        for ($i = 0; $i < 20; $i++) {
            DB::table('purchases')->insert([
                // Customer info
                'customer_name' => $faker->name,
                'phone_number' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'customer_address' => $faker->address,

                // Purchase info
                'purchase_date' => $faker->date(),
                'product_details' => $faker->sentence(6),
                'imei_number' => $faker->unique()->numerify('##########'), // 10-digit unique IMEI
                'customer_id_proof' => $faker->imageUrl(200, 200, 'people'),
                'captured_photo' => $faker->imageUrl(200, 200, 'technics'),

                // Payment info
                'payment_method' => $faker->randomElement(['cash', 'card', 'bank_transfer', 'other']),
                'purchase_amount' => $faker->randomFloat(2, 50, 2000),

                // Category info
                'category' => $faker->word,
                'sub_category' => $faker->word,

                // Bank transfer (nullable)
                'bank_transfer_name' => $faker->optional()->name,
                'bank_transfer_account' => $faker->optional()->bankAccountNumber,
                'bank_transfer_sort_code' => $faker->optional()->numerify('##-##-##'),

                // Shop & Branch
                'day' => $faker->dayOfMonth,
                'month' => $faker->month,
                'year' => $faker->year,
                'company' => $faker->company,
                'branch' => $faker->city,

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
