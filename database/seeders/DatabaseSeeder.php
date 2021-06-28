<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userId = time();

        DB::table('users')->insert([
            'id' => $userId,
            'name' => Str::random(10),
            'payment_gateway' => 'moneris',
            'moneris_store_id' => 'store5',
            'moneris_api_token' => 'yesguy',
            'moneris_country_code' => 'CA',
            'moneris_test_mode' => '1',
            'updated_at' => time(),
            'created_at' => time(),
        ]);

        DB::table('customers')->insert([
            'user_id' => $userId,
            'card_holder' => Str::random(10),
            'card_number' => '4242424242424242',
            'card_expiry_month' => '11',
            'card_expiry_year' => '20',
            'updated_at' => time(),
            'created_at' => time(),
        ]);


    }
}
