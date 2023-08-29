<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // HINT: order of executing seeders are very important

        // currency hashsed till confirm business
        // $this->call(CurrencySeeder::class);

        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
    }
}
