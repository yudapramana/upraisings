<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bankAccounts = [
            [
                'bank_name' => 'BCA',
                'account_number' => '123-456-7890',
                'account_holder' => 'PT. ABC Indonesia'
            ],
            [
                'bank_name' => 'Mandiri',
                'account_number' => '987-654-3210',
                'account_holder' => 'PT. ABC Mandiri'
            ],
            [
                'bank_name' => 'BNI',
                'account_number' => '555-333-2221',
                'account_holder' => 'PT. ABC BNI'
            ],
            [
                'bank_name' => 'BRI',
                'account_number' => '444-888-7776',
                'account_holder' => 'PT. ABC BRI'
            ],
            [
                'bank_name' => 'CIMB',
                'account_number' => '999-111-5552',
                'account_holder' => 'PT. ABC CIMB'
            ],
        ];

        DB::table('banks')->insert($bankAccounts);
    }
}
