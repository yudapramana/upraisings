<?php

namespace App\Http\Controllers;

use App\Models\EWallet;
use Illuminate\Http\Request;
use Auth;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Trip;
use App\Models\User;

class RideController extends Controller
{

    public function ride()
    {
        return view('trip.ride', [
            'title' => 'Naik Angkot',
        ]);
    }


    public function process(Request $request)
    {

        $request->validate([
            'qrcode_string' => 'required',
            'geton_location' => 'required',
            'geton_latitude' => 'required',
            'geton_longitude' => 'required',
        ]);

        $ewallet = EWallet::where('qrcode_string', $request->qrcode_string)->with('user.vehicle.angkotType')->first();
        $vehicle = $ewallet->user->vehicle;


        // dd($vehicle);
        $trip = Trip::create([
            'geton_location'            => $request->geton_location,
            'geton_latitude'            => $request->geton_latitude,
            'geton_longitude'           => $request->geton_longitude,
            'geton_geolocation'         => $request->geton_latitude . ',' . $request->geton_longitude,
            'user_id'                   => auth()->id(),
            'status'                    => 'ongoing',
            'license_plate'             => $vehicle->license_plate,
            'vehicle_photo'             => $vehicle->vehicle_photo,
            'route_number'              => $vehicle->angkotType->route_number,
            'route_name'                => $vehicle->angkotType->route_name,
            'color'                     => $vehicle->angkotType->color,
            'driver_name'               => $vehicle->user->name,
            'partner_id'                => $ewallet->user_id,
        ]);

        return redirect()->route('customer.home')->with('success', 'Perjalanan dimulai! ID: ' . $trip->id);
    }
}

