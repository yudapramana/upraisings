<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\EWallet;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;



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
                'name'          => 'Loe Marksman',
                'email'         => 'partner@partner.com',
                'role'          => 'partner',
                'password'      => Hash::make('partner'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Qreshna Murni Akisan',
                'email'         => 'partner2@partner.com',
                'role'          => 'partner',
                'password'      => Hash::make('partner'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Toufik Ghozali',
                'email'         => 'tghoz@gmail.com',
                'role'          => 'customer',
                'password'      => Hash::make('customer'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Annisa Sabrina',
                'email'         => 'Annsab@gmail.com',
                'role'          => 'customer',
                'password'      => Hash::make('customer'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($users as $key => $user) {
            $user = User::create($user);
            if($user->role == 'customer') {
                $user->account_verification = 'verified';
                $user->save();
            }
            $userid = $user->id;


            // Generate unique string
            // $qrcode_string = Str::uuid()->toString();
            // $imagePath = 'storage/qrcodes/' . $qrcode_string . '.png';
            // QrCode::format('png')->size(300)->generate($qrcode_string, public_path($imagePath));

            // Step 1: Generate unique string
            $uniqueString = Str::uuid()->toString();

            // Step 2: Generate QR Code as a raw PNG
            // $qrImage = QrCode::format('png')->size(300)->generate($uniqueString);

            // Step 3: Create a temporary file
            // $tempFilePath = tempnam(sys_get_temp_dir(), 'qr_');
            // file_put_contents($tempFilePath, $qrImage);

            // Step 4: Upload to Cloudinary
            // $uploadedFile = Cloudinary::upload($tempFilePath, [
            //     'folder' => 'ewallet_qrcodes',
            //     'public_id' => $uniqueString,
            // ]);

            // Step 5: Get secure URL
            // $qrCodeUrl = $uploadedFile->getSecurePath();

            
            EWallet::create([
                'user_id' => $userid,
                'qrcode_string' => $uniqueString
            ]);
        }

        $user = User::where('name', 'Toufik Ghozali')->first();
        $user->load('ewallet');
        $ewallet = $user->ewallet;

        $payment_method = 'bank_transfer';
        $ewallet->balance += 200000;
        $ewallet->save();

        $bank = Bank::find(1);
        Transaction::create([
            'ewallet_id' => $ewallet->id,
            'type' => 'Top-up',
            'method' => 'bank_transfer',
            'operation' => 'plus',
            'last_saldo' => $ewallet->balance,
            'amount' => 200000,
            'description' => 'Top-up via Bank ' . $bank->bank_name,
            'bank_topup_id' => $bank->id
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
            'description' => 'Top-up via Bank ' . $bank->bank_name,
            'bank_topup_id' => $bank->id
        ]);

        

    }
}