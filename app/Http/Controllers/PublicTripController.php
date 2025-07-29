<?php

namespace App\Http\Controllers;

use App\Models\EWallet;
use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PublicTripController extends Controller
{
     // Tampilkan form berdasarkan angkot_id
    public function showForm($angkot_id)
    {
        return view('trip.naik-angkot-public', compact('angkot_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'angkot_id'         => 'required|exists:ewallets,qrcode_string',
            'customer_name'     => 'required|string|max:100',
            'customer_phone'    => 'required|string|max:20',
            'latitude'          => 'required|numeric',
            'longitude'         => 'required|numeric',
            'location_text'     => 'nullable|string|max:255',
        ]);

        $qrcode_string = $request->angkot_id;

        // Ambil info ewallet dan angkot
        $ewallet = EWallet::where('qrcode_string', $qrcode_string)
            ->with('user.vehicle.angkotType')
            ->firstOrFail();

        $vehicle = $ewallet->user->vehicle;

        // Buat atau ambil user customer berdasarkan nomor HP
        $user = User::firstOrCreate(
            ['mobile_phone' => $request->customer_phone],
            [
                'name'     => $request->customer_name,
                'email'    => 'cust_' . $request->customer_phone . '@example.com',
                'password' => bcrypt(Str::random(12)),
                'role'     => 'customer',
            ]
        );

        $uniqueString = Str::uuid()->toString();
        EWallet::create([
            'user_id' => $user->id,
            'qrcode_string' => $uniqueString
        ]);

        // Login otomatis ke user tersebut
        Auth::login($user);

        // Simpan Trip
        $trip = Trip::create([
            'geton_location'    => $request->location_text,
            'geton_latitude'    => $request->latitude,
            'geton_longitude'   => $request->longitude,
            'geton_geolocation' => $request->latitude . ',' . $request->longitude,
            'user_id'           => $user->id,
            'status'            => 'ongoing',
            'license_plate'     => $vehicle->license_plate,
            'vehicle_photo'     => $vehicle->vehicle_photo,
            'route_number'      => $vehicle->angkotType->route_number,
            'route_name'        => $vehicle->angkotType->route_name,
            'color'             => $vehicle->angkotType->color,
            'driver_name'       => $vehicle->user->name,
            'partner_id'        => $ewallet->user_id,
        ]);

        return redirect()->route('customer.home')->with('success', 'Perjalanan dimulai! ID: ' . $trip->id);
    }

    
}
