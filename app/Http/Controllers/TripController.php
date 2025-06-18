<?php

namespace App\Http\Controllers;

use App\Models\EWallet;
use App\Models\Transaction;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function show($id = null)
    {
        if($id) {
            $trip = Trip::where('id', $id)
                        ->where('user_id', Auth::id()) // keamanan: hanya boleh lihat trip milik sendiri
                        ->firstOrFail();

        return view('trip.show', compact('trip'));
        } else {
            $trip = Trip::where([
                'user_id' => Auth::id(),
                'status' => 'ongoing'
                ])->first();

                if(!$trip){
                    return redirect()->route('customer.home')->with('error', 'Trip tidak ditemukan!.');
                }
        }

        // dd($trip);

        return view('trip.show', compact('trip'));
    }

   public function complete(Request $request, Trip $trip)
    {
        // dd($request->all());
        $user = Auth::user();
        $cWallet = EWallet::where('user_id', $user->id)->first();
        $pWallet = EWallet::where('user_id', $trip->partner_id)->first();

        $userPartner = User::find($pWallet->user_id);
        if($userPartner->role != 'partner') {
            return redirect()->route('ride')->with('error', 'Penerima Bukan Mitra Angkot!.');
        }

        // Misalnya tarif angkot = Rp 5000
        // $fare = 5000;

        $trip->update([
            'getoff_latitude' => $request->getoff_latitude,
            'getoff_longitude' => $request->getoff_longitude,
            'getoff_location' => $request->getoff_location,
            'getoff_geolocation' => $request->getoff_latitude . ',' . $request->getoff_longitude,
        ]);

        $distance = 0;
        $fare = 0;

        if ($trip->geton_latitude && $trip->getoff_latitude) {
            $distance = $this->calculateDistance(
                $trip->geton_latitude, $trip->geton_longitude,
                $trip->getoff_latitude, $trip->getoff_longitude
            );

            $fare = $this->calculateFare($distance);
        }

        // Kurangi Saldo Customer
        $cWallet->balance -= $fare;
        $cWallet->save();
        

        // Simpan transaksi Customer
        $customerTx = Transaction::create([
            'ewallet_id' => $cWallet->id,
            'type' => 'Payment',
            'method' => 'System',
            'operation' => 'minus',
            'last_saldo' => $cWallet->balance,
            'amount' => $fare,
            'description' => "Payment Angkot (ID: {$pWallet->qrcode_string})"
        ]);

        // Tambahkan Saldo Mitra
        $pWallet->balance += $fare;
        $pWallet->save();

        // Simpan transaksi
        Transaction::create([
            'ewallet_id' => $pWallet->id,
            'type' => 'Payment',
            'method' => 'System',
            'operation' => 'plus',
            'last_saldo' => $pWallet->balance,
            'amount' => $fare,
            'description' => "Receive Payment (ID: {$cWallet->qrcode_string})"
        ]);

        $trip->update([
            'status' => 'completed',
            'arrival_time' => now(),
            'trip_fare' => $fare,
            'distance' => $distance,
        ]);

        return redirect()->route('trip.show', $trip->id)->with('success', 'Perjalanan diselesaikan.');
    }


    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;

        return round($distance, 2); // hasil dalam km
    }

    private function calculateFare($distance)
    {
        if ($distance <= 5) {
            return 3000;
        } else {
            return 5000;
        }
    }
}
