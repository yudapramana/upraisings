<?php

namespace Database\Seeders;

use App\Models\EWallet;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'              => 'Agus Budi Mulyanto',
                'mobile_phone'      => '084389877771',
                'email'             => 'agusbunto@gmail.com',
                'city_register'     => 1371,
                'password'          => Hash::make('12345678'),
                'bank_name'         => 'BCA',
                'account_number'    => 54519899,
                'account_holder'    => 'Agus Budi Mulyanto',
                'angkot_type_id'    => 7,
                'license_plate'     => 'BA 9981 OA',
                'role'              => 'partner',
                'vehicle_photo'     => 'http://res.cloudinary.com/dezj1x6xp/image/upload/v1750136964/PandanViewMandeh/images_clwr56.jpg',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'name'              => 'Rina Marlina',
                'mobile_phone'      => '081234567890',
                'email'             => 'rina.marlina@example.com',
                'city_register'     => 1301,
                'password'          => Hash::make('rinamarlina'),
                'bank_name'         => 'Bank Nagari',
                'account_number'    => 1234567890,
                'account_holder'    => 'Rina Marlina',
                'angkot_type_id'    => 5,
                'license_plate'     => 'BA 1234 ZN',
                'role'              => 'partner',
                'vehicle_photo'     => 'http://res.cloudinary.com/dezj1x6xp/image/upload/v1750137048/PandanViewMandeh/images_zpnzyt.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'Dedi Suryanto',
                'mobile_phone'      => '082198765432',
                'email'             => 'dedi.surya@gmail.com',
                'city_register'     => 1302,
                'password'          => Hash::make('dedisurya'),
                'bank_name'         => 'BRI',
                'account_number'    => 9876543210,
                'account_holder'    => 'Dedi Suryanto',
                'angkot_type_id'    => 3,
                'license_plate'     => 'BA 8765 KY',
                'role'              => 'partner',
                'vehicle_photo'     => 'http://res.cloudinary.com/dezj1x6xp/image/upload/v1750137097/PandanViewMandeh/images_mg1wgz.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'Siti Nurjanah',
                'mobile_phone'      => '083167845678',
                'email'             => 'siti.nurjanah@gmail.com',
                'city_register'     => 1375,
                'password'          => Hash::make('nurjanah2024'),
                'bank_name'         => 'Mandiri',
                'account_number'    => 1029384756,
                'account_holder'    => 'Siti Nurjanah',
                'angkot_type_id'    => 2,
                'license_plate'     => 'BA 5566 QT',
                'role'              => 'partner',
                'vehicle_photo'     => 'http://res.cloudinary.com/dezj1x6xp/image/upload/v1750137233/PandanViewMandeh/modif-angkot-1-ae2f_sa86ty.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'Taufik Hidayat',
                'mobile_phone'      => '084312312312',
                'email'             => 'taufik.hidayat@example.com',
                'city_register'     => 1304,
                'password'          => Hash::make('taufik123'),
                'bank_name'         => 'BNI',
                'account_number'    => 3210987654,
                'account_holder'    => 'Taufik Hidayat',
                'angkot_type_id'    => 9,
                'license_plate'     => 'BA 1100 TR',
                'role'              => 'partner',
                'vehicle_photo'     => 'http://res.cloudinary.com/dezj1x6xp/image/upload/v1750137233/PandanViewMandeh/modif-angkot-1-ae2f_sa86ty.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];


        foreach ($users as $key => $user) {
            $partner = User::create([
                'name' => $user['name'],
                'mobile_phone' => $user['mobile_phone'],
                'email' => $user['email'],
                'city_register' => $user['city_register'],
                'password' => $user['password'],
                'role' => 'partner',
                'bank_name' => $user['bank_name'],
                'account_number' => $user['account_number'],
                'account_holder' => $user['account_holder'],
            ]);

            $uniqueString = Str::uuid()->toString();
            // Simpan Saldo E-Wallet
            EWallet::create([
                'user_id' => $partner->id,
                'qrcode_string' => $uniqueString
            ]);

            // Simpan Kendaraan
            Vehicle::create([
                'user_id' => $partner->id,
                'angkot_type_id' => $user['angkot_type_id'],
                'vehicle_photo' => $user['vehicle_photo'],
                'license_plate' => strtoupper($user['license_plate']),
            ]);
        }
    }
}
