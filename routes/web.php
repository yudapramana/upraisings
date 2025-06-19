<?php

use App\Http\Controllers\AngkotController;
use App\Http\Controllers\Approval\PartnerController as ApprovalPartnerController;
use App\Http\Controllers\Approval\PaymentController as ApprovalPaymentController;
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
use App\Http\Controllers\RideController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\WalletController;
use App\Models\Trip;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


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
Route::get('phpmyinfo', function () {
    phpinfo(); 
})->name('phpmyinfo');

Route::get('filltriptrxid', function() {
Trip::whereNull('trip_transaction_id')->get()->each(function ($trip) {
    $trip->trip_transaction_id = Trip::generateTransactionId();
    $trip->save();
});
return 'done';
});

Auth::routes();
Route::resource('/', HomeController::class);
Route::get('register-partner', [RegisterController::class, 'partner'])->name('register.partner');
Route::post('store-partner', [RegisterController::class, 'storePartner'])->name('store.partner');

Route::get('register-customer', [RegisterController::class, 'customer'])->name('register.customer');
Route::post('store-customer', [RegisterController::class, 'storeCustomer'])->name('store.customer');


Route::group(['prefix' => 'partner', 'middleware' => ['auth', 'user-access:partner']], function(){
    Route::get('/', [PartnerController::class, 'index'])->name('partner.home');

    Route::get('/profile', [ProfileController::class, 'indexPartner'])->name('partner.profile');
    Route::post('/profile/update', [ProfileController::class, 'updatePartner'])->name('partner.profile.update');

    Route::get('/withdraw', [PartnerController::class, 'withdraw'])->name('partner.withdraw');
    Route::post('/withdraw/process', [PartnerController::class, 'withdrawProcess'])->name('partner.withdraw.process');

    Route::get('/qrcode', [PartnerController::class, 'showQr'])->name('partner.qrcode');
    Route::get('/trip-list-partner', [TripController::class, 'indexPartner'])->name('trip.list.partner');
    Route::get('/trip/{id?}', [TripController::class, 'showPartner'])->name('trip.show.partner');
    Route::get('/transaction/list', [WalletController::class, 'transactions'])->name('transaction.list.partner');


});


// Route::middleware(['auth', 'user-access:customer'])->group(function () {
Route::group(['prefix' => 'customer', 'middleware' => ['auth', 'user-access:customer', 'check.ongoing.trip']], function(){
    Route::get('/', [CustomerController::class, 'index'])->name('customer.home');
    Route::get('/profile', [ProfileController::class, 'indexCustomer'])->name('customer.profile');
    Route::post('/profile/update', [ProfileController::class, 'updateCustomer'])->name('customer.profile.update');
    
    Route::get('/topup', [WalletController::class, 'showTopUpForm'])->name('topup');
    Route::post('/topup', [WalletController::class, 'processTopUp'])->name('topup.process');
    Route::post('/topup/upload/{topupId}', [WalletController::class, 'uploadProof'])->name('topup.upload');
    Route::post('/topup/{topupId}/submit-proof', [WalletController::class, 'submitProof'])->name('topup.submitProof');
    Route::get('/transaction/list', [WalletController::class, 'transactions'])->name('transaction.list.customer');



    Route::get('/pay', [PaymentController::class, 'showPaymentForm'])->name('pay');
    Route::post('/pay', [PaymentController::class, 'processPayment'])->name('pay.process');
    Route::get('/payment/success/{id}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

    Route::get('/ride', [RideController::class, 'ride'])->name('ride');
    Route::post('/ride/process', [RideController::class, 'process'])->name('ride.process');

    Route::get('/angkot/{id}', [AngkotController::class, 'getAngkot'])->name('angkot.get');

    Route::get('/trip/{id?}', [TripController::class, 'show'])->name('trip.show.customer');
    Route::patch('/trip/{trip}/complete', [TripController::class, 'complete'])->name('trip.complete')->middleware('auth');
    Route::get('/trip-list', [TripController::class, 'index'])->name('trip.list');

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
    // Route::get('approval/history', [HistoryListController::class, 'index']);
    // Route::resource('approval/submission-list-approval', ApprovalPartnerController::class);

    Route::get('/approval/partner-verification', [ApprovalPartnerController::class, 'index'])->name('partner-verification.index');
    Route::put('/approval/partner-verification/update/{id}', [ApprovalPartnerController::class, 'update'])->name('partner-verification.update');
    Route::delete('/approval/partner-verification/delete/{id}', [ApprovalPartnerController::class, 'destroy'])->name('partner-verification.delete');

    Route::get('/approval/topup-verification', [ApprovalPaymentController::class, 'index'])->name('admin.ewallet.index');
    Route::put('/approval/topup-verification/{id}', [ApprovalPaymentController::class, 'verify'])->name('admin.ewallet.verify');



});


Route::get('/test-cloudinary', function () {

    return public_path('avatar.png');
    $result = Cloudinary::upload(public_path('avatar.png'));
    return $result->getSecurePath();
});

 