<?php

namespace Database\Seeders;

use App\Models\EWallet;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'          => 'admin',
                'email'         => 'admin@admin.com',
                'role'          => 'admin',
                'password'      => Hash::make('admin'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'approval',
                'email'         => 'approval@approval.com',
                'role'          => 'approval',
                'password'      => Hash::make('approval'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'partner',
                'email'         => 'partner@partner.com',
                'role'          => 'partner',
                'password'      => Hash::make('partner'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'customer',
                'email'         => 'customer@customer.com',
                'role'          => 'customer',
                'password'      => Hash::make('customer'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($users as $key => $user) {
            $userid = User::create($user)->id;
            EWallet::create([
                'user_id' => $userid
            ]);
        }

        $user = User::where('name', 'customer')->first();
        $user->load('ewallet');
        $ewallet = $user->ewallet;

        $payment_method = 'bank_transfer';
        $ewallet->balance += 200000;
        $ewallet->save();
        Transaction::create([
            'ewallet_id' => $ewallet->id,
            'type' => 'Top-up',
            'method' => 'bank_transfer',
            'operation' => 'plus',
            'last_saldo' => $ewallet->balance,
            'amount' => 200000,
            'description' => 'Top-up via ' . $payment_method,
        ]);

        
        $ewallet->balance += 100000;
        $ewallet->save();
        Transaction::create([
            'ewallet_id' => $ewallet->id,
            'type' => 'Top-up',
            'method' => 'bank_transfer',
            'operation' => 'plus',
            'last_saldo' => $ewallet->balance,
            'amount' => 100000,
            'description' => 'Top-up via ' . $payment_method,
        ]);

        

    }
}