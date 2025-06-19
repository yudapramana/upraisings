<?php

namespace App\Http\Controllers;

use App\Models\AngkotType;
use App\Models\EWallet;
use DB;

use App\Models\SubmissionList;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class RegisterController extends Controller {

    public function partner(){

        if(Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.home');
            }else if (Auth::user()->role == 'approval') {
                return redirect()->route('approval.home');
            }else if (Auth::user()->role == 'partner') {
                return redirect()->route('partner.home');
            }else if (Auth::user()->role == 'customer') {
                return redirect()->route('customer.home');
            }else{
                return redirect()->route('index');
            }
        } else {
            $angkotTypes = AngkotType::orderBy('route_number')->get();
            return view('landing.register', [
                'title' => 'Pendaftaran Angkot',
                'role' => 'partner',
                'angkotTypes' => $angkotTypes
            ]);
        }
        
    }

    public function customer(){

        if(Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.home');
            }else if (Auth::user()->role == 'approval') {
                return redirect()->route('approval.home');
            }else if (Auth::user()->role == 'partner') {
                return redirect()->route('partner.home');
            }else if (Auth::user()->role == 'customer') {
                return redirect()->route('customer.home');
            }else{
                return redirect()->route('index');
            }
        } else {
            return view('landing.register', [
                'title' => 'Pendaftaran Pengguna',
                'role' => 'customer'
            ]);
        }
    }

    public function storePartner(Request $request)
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
            // Custom messages
            
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
            'angkot_type_id.required' => 'Jenis angkot wajib dipilih.',
            'angkot_type_id.exists' => 'Trayek angkot tidak valid.',
            'license_plate.required' => 'Plat nomor kendaraan wajib diisi.',
            'license_plate.unique' => 'Plat nomor sudah terdaftar.',
            'vehicle_photo.required' => 'Foto angkot wajib diunggah.',
        ]);

        // dd($request->all());

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
            // Simpan Saldo E-Wallet
            EWallet::create([
                'user_id' => $partner->id,
                'qrcode_string' => $uniqueString
            ]);

            // Upload Foto Angkot
            // $vehiclePhotoPath = $request->file('vehicle_photo')->store('vehicle_photos', 'public');
                // 'vehicle_photo' => $vehiclePhotoPath,

            // Simpan Kendaraan
            Vehicle::create([
                'user_id' => $partner->id,
                'angkot_type_id' => $request->angkot_type_id,
                'license_plate' => strtoupper($request->license_plate),
            ]);

            DB::commit();


            Auth::login($partner);
            return redirect()->route('partner.home')->with('success', 'Pendaftaran berhasil! Anda telah login.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }

    // public function storePartner(Request $request){
    //     $request->validate([
    //         'nama_lengkap' => 'required|string|max:255',
    //         'mobile_phone' => 'required|regex:/^08[0-9]{8,11}$/',
    //         'email' => 'required|email|unique:users,email',
    //         'city_register' => 'required',
    //         'password' => 'required|min:6',
    //     ], [
    //         'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
    //         'mobile_phone.required' => 'Nomor HP wajib diisi.',
    //         'mobile_phone.regex' => 'Format nomor HP tidak valid.',
    //         'email.required' => 'Email wajib diisi.',
    //         'email.email' => 'Format email tidak valid.',
    //         'email.unique' => 'Email sudah terdaftar.',
    //         'city_register.required' => 'Kota tempat mendaftar wajib dipilih.',
    //         'city_register.exists' => 'Kota yang dipilih tidak valid.',
    //         'password.required' => 'Password wajib diisi.',
    //         'password.min' => 'Password minimal harus 6 karakter.',
    //     ]);

    //     $partner = User::create([
    //         'name' => $request->nama_lengkap,
    //         'mobile_phone' => $request->mobile_phone,
    //         'email' => $request->email,
    //         'city_register' => $request->city_register,
    //         'password' => Hash::make($request->password),
    //         'role' => 'partner'
    //     ]);

    //     EWallet::create([
    //         'user_id' => $partner->id
    //     ]);

    //     Auth::login($partner);

    //     // Redirect to dashboard or home
    //     return redirect()->route('partner.home')->with('success', 'Pendaftaran berhasil! Anda telah login.');
    // }

    /**
     * Store a newly registered customer.
     */
    public function storeCustomer(Request $request)
    {
        try {

            // dd($request->all());
            // Validasi input dari form
            $validator = Validator::make($request->all(), [
                'nama_lengkap' => 'required|string|max:255',
                'mobile_phone' => ['required', 'string', 'regex:/^(\+62|62|0)[0-9]{9,12}$/', 'unique:users,mobile_phone'],
                'email' => 'required|email|unique:users,email',
                // 'password' => 'required|min:6',
            ], [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
                'mobile_phone.required' => 'Nomor HP wajib diisi.',
                'mobile_phone.regex' => 'Format nomor HP tidak valid. Gunakan angka saja (10-12 digit).',
                'mobile_phone.unique' => 'Nomor HP sudah terdaftar.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
            ]);
    
            // Jika validasi gagal, kembalikan error dalam format JSON
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Simpan data penumpang ke database
            $customer = User::create([
                'name' => $request->nama_lengkap,
                'mobile_phone' => $request->mobile_phone,
                'password' => Hash::make($request->password), // Pastikan password tidak kosong
                'email' => $request->email,
                'role' => 'customer'
            ]);

            EWallet::create([
                'user_id' => $customer->id
            ]);
    
            // Login otomatis setelah registrasi
            Auth::login($customer);
    
            // Berhasil, kembalikan response JSON
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Anda telah login.'
            ]);
        } catch (\Exception $e) {
            // Tangkap error lainnya
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

}
