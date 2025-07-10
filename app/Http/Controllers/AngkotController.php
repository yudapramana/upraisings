<?php

namespace App\Http\Controllers;

use App\Models\AngkotType;
use App\Models\EWallet;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class AngkotController extends Controller
{
    public function getAngkot($id)
    {
        $ewallet = EWallet::where('qrcode_string', $id)->with('user.vehicle')->first();
        return $ewallet->user;
    }

    public function index()
    {
        $angkots = User::where([
                            'role' => 'partner',
                            'account_verification' => 'pending'
                        ])
                        ->with('ewallet', 'vehicle.angkotType')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // $flattened = $angkots->map(function ($angkot) {
        //     return [
        //         ...$angkot->toArray(),
        //         ...($angkot->ewallet?->toArray() ?? []),
        //         ...($angkot->vehicle?->toArray() ?? []),
        //         ...($angkot->vehicle?->angkotType?->toArray() ?? []),
        //     ];
        // });

        // collect($flattened)->mapInto(User::class);
        // return $angkots;

        $angkotTypes = AngkotType::orderBy('route_number')->get();
        $params = [
            "titlePages"    => 'Manajemen - Kelola Angkot',
            "angkots"         => $angkots,
            "angkotTypes"         => $angkotTypes,
        ];

        return view('dashboard.angkot.index', $params);
    }

    public function store(Request $request)
    {
        $request->validate([
            // User Validation
            'nama_lengkap' => 'required|string|max:255',
            'mobile_phone' => 'required|regex:/^08[0-9]{8,11}$/',
            'email' => 'required|email|unique:users,email',
            'city_register' => 'required',
            'password' => 'required|min:6',
            'vehicle_photo' => 'required',

            // Vehicle Validation
            'angkot_type_id' => 'required|exists:angkot_types,id',
            'license_plate' => 'required|string|max:20|unique:vehicles,license_plate',
        ], [
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
            'angkot_type_id.required' => 'Jenis angkot wajib dipilih.',
            'angkot_type_id.exists' => 'Trayek angkot tidak valid.',
            'license_plate.required' => 'Plat nomor kendaraan wajib diisi.',
            'license_plate.unique' => 'Plat nomor sudah terdaftar.',
            'vehicle_photo.required' => 'Foto angkot wajib diunggah.',
        ]);

        DB::beginTransaction();
        try {
            // Simpan User
            $partner = User::create([
                'name' => $request->nama_lengkap,
                'mobile_phone' => $request->mobile_phone,
                'email' => $request->email,
                'city_register' => $request->city_register,
                'password' => Hash::make($request->password),
                'role' => 'partner',
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_holder' => $request->account_holder,
            ]);

            $uniqueString = Str::uuid()->toString();

            // Simpan E-Wallet
            EWallet::create([
                'user_id' => $partner->id,
                'qrcode_string' => $uniqueString
            ]);

            // Simpan Kendaraan
            Vehicle::create([
                'user_id' => $partner->id,
                'angkot_type_id' => $request->angkot_type_id,
                'license_plate' => strtoupper($request->license_plate),
                'vehicle_photo' => $request->vehicle_photo,
            ]);

            DB::commit();

            // ✅ Respon AJAX
            if ($request->ajax()) {
                return response()->json(['message' => 'Pendaftaran berhasil'], 200);
            }

            // Fallback: jika bukan AJAX
            return redirect()->back()->with('success', 'Data angkot berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat menyimpan data.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }


    public function update(Request $request, $id)
    {
        $angkot = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'mobile_phone' => 'required|string|max:20',
            'email'        => 'required|email|unique:angkots,email,' . $angkot->id,
            'city_register'=> 'required|string',
        ]);

        $angkot->update([
            'nama_lengkap' => $request->nama_lengkap,
            'mobile_phone' => $request->mobile_phone,
            'email'        => $request->email,
            'city_register'=> $request->city_register,
        ]);

        return redirect()->back()->with('success', 'Data angkot berhasil diupdate.');
    }

    public function destroy($id)
    {
        $angkot = User::findOrFail($id);
        $angkot->delete();

        return response()->json(['success' => true]);
    }
}
