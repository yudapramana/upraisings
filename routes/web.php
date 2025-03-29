<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\SubmissionListController;
use App\Http\Controllers\HistoryListController;
use App\Http\Controllers\Partner\ProfileController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WalletController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::resource('/', HomeController::class);
Route::get('register-partner', [RegisterController::class, 'partner'])->name('register.partner');
Route::post('store-partner', [RegisterController::class, 'storePartner'])->name('store.partner');

Route::get('register-customer', [RegisterController::class, 'customer'])->name('register.customer');
Route::post('store-customer', [RegisterController::class, 'storeCustomer'])->name('store.customer');


Route::group(['prefix' => 'partner', 'middleware' => ['auth', 'user-access:partner']], function(){
    Route::get('/', [PartnerController::class, 'index'])->name('partner.home');

    Route::get('/profile', [ProfileController::class, 'index'])->name('partner.profile');
    Route::post('//profile/update', [ProfileController::class, 'update'])->name('partner.profile.update');

    Route::get('/partner/withdraw', [PartnerController::class, 'withdraw'])->name('partner.withdraw');
    Route::post('/partner/withdraw/process', [PartnerController::class, 'withdrawProcess'])->name('partner.withdraw.process');
});


// Route::middleware(['auth', 'user-access:customer'])->group(function () {
Route::group(['prefix' => 'customer', 'middleware' => ['auth', 'user-access:customer']], function(){
    Route::get('/', [CustomerController::class, 'index'])->name('customer.home');
    Route::get('/topup', [WalletController::class, 'showTopUpForm'])->name('topup');
    Route::post('/topup', [WalletController::class, 'processTopUp'])->name('topup.process');

    Route::get('/pay', [PaymentController::class, 'showPaymentForm'])->name('pay');
    Route::post('/pay', [PaymentController::class, 'processPayment'])->name('pay.process');
});

/*--------------------------------------------------------------------------------------
All Admin Routes List
----------------------------------------------------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('admin', [DashboardController::class, 'index'])->name('admin.home');
    Route::get('admin/history', [HistoryListController::class, 'index']);

    Route::resource('admin/users', UsersController::class);
    Route::resource('admin/vehicle', VehicleController::class);
    Route::resource('admin/submission-list', SubmissionListController::class);
});


/*--------------------------------------------------------------------------------------
All Approval Routes List
----------------------------------------------------------------------------------------*/
Route::middleware(['auth', 'user-access:approval'])->group(function () {
    Route::get('approval', [DashboardController::class, 'index'])->name('approval.home');
    Route::get('approval/history', [HistoryListController::class, 'index']);

    Route::resource('approval/submission-list-approval', SubmissionListController::class);
});

 