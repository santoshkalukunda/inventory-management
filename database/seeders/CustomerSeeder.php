<?php

namespace Database\Seeders;

use App\Models\Customer;
use Database\Factories\CustomerFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()
        ->count(50)
        ->create();
    }
}
