<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'ABC Traders & Suppliers',
            'address' => 'Butwal-01, Rupandihi, Lumbini Province ',
            'contact' => '091503094,9801234567',
            'email' => 'info@inventory.com.np',
            'type' => 'PAN',
            'pan_vat' => '36548368',
            ]);
    }
}
