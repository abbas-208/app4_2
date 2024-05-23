<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\MasterTradingController;
use App\Http\Controllers\Admin\Trading\SellerTradingHistoryController;
use App\Http\Controllers\Admin\Trading\BuyerTradingHistoryController;
use App\Http\Controllers\Admin\Trading\BothTradingHistoryController;
use App\Http\Controllers\Admin\Trading\SellerMarketController;
use App\Http\Controllers\Admin\Trading\BuyerMarketController;
use App\Http\Controllers\Admin\Trading\BothMarketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/trading', [HomeController::class, 'showEnergyProducts'])->name('trading');

Auth::routes();

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Master Trading
Route::resource('masterTrading', MasterTradingController::class);
Route::get('/ajaxGetEnergies/{action_buttons}', [MasterTradingController::class, 'ajaxGetEnergies'])->name('ajaxGetEnergies');
Route::post('/ajaxCreateEnergy', [MasterTradingController::class, 'ajaxCreateEnergy'])->name('ajaxCreateEnergy');
Route::post('/ajaxUpdateEnergy', [MasterTradingController::class, 'ajaxUpdateEnergy'])->name('ajaxUpdateEnergy');
Route::post('/ajaxDeleteItem', [MasterTradingController::class, 'ajaxDeleteItem'])->name('ajaxDeleteItem');
Route::get('/ajaxGetEnergyHistory/{energy_id}', [MasterTradingController::class, 'ajaxGetEnergyHistory'])->name('ajaxGetEnergyHistory');

Route::get('/ajaxGetFees', [MasterTradingController::class, 'ajaxGetFees'])->name('ajaxGetFees');
Route::post('/ajaxUpdateFee', [MasterTradingController::class, 'ajaxUpdateFee'])->name('ajaxUpdateFee');
Route::get('/ajaxGetFeesHistory/{fee_id}', [MasterTradingController::class, 'ajaxGetFeesHistory'])->name('ajaxGetFeesHistory');

// Seller Trading
Route::get('/sellerTradingHistory', [SellerTradingHistoryController::class, 'index'])->name('sellerTradingHistory');
Route::get('/ajaxGetSellHistory/{energy_product_id}', [SellerTradingHistoryController::class, 'ajaxGetSellHistory'])->name('ajaxGetSellHistory');
Route::get('/sellerMarket', [SellerMarketController::class, 'index'])->name('sellerMarket');
Route::get('/sellEnergy', [SellerMarketController::class, 'create'])->name('Market\SellEnergy');
Route::post('/storeToSellEnergy', [SellerMarketController::class, 'store'])->name('storeToSellEnergy');

// Buyer Trading
Route::get('/buyerTradingHistory', [BuyerTradingHistoryController::class, 'index'])->name('buyerTradingHistory');
Route::get('/buyerMarket', [BuyerMarketController::class, 'index'])->name('buyerMarket');
Route::get('/buyEnergy/{energy_product_id}', [BuyerMarketController::class, 'buyForm'])->name('Market\BuyEnergy');
Route::get('/ajaxGetPriceDetails/{energy_id}', [BuyerMarketController::class, 'ajaxGetPriceDetails'])->name('ajaxGetPriceDetails');
Route::post('/storeToBuyEnergy', [BuyerMarketController::class, 'buyEnergy'])->name('storeToBuyEnergy');

// Both Buyer & Seller Trading
Route::get('/bothTradingHistory', [BothTradingHistoryController::class, 'index'])->name('bothTradingHistory');
Route::get('/bothMarket', [BothMarketController::class, 'index'])->name('bothMarket');

// User management
Route::get('/manageUser', [UserManagementController::class, 'index'])->name('manageUser');
Route::get('/createUser', [UserManagementController::class, 'createUser'])->name('createUser');
Route::post('/activateUser', [UserManagementController::class, 'activateUser'])->name('activateUser');
Route::post('/deactivateUser', [UserManagementController::class, 'deactivateUser'])->name('deactivateUser');
Route::delete('/deleteUser', [UserManagementController::class, 'deleteUser'])->name('deleteUser');

// Profile
Route::resource('profile', ProfileController::class);
Route::get('/changePassword', [ProfileController::class, 'changePassword'])->name('profile\changePassword');
Route::put('/updatePassword', [ProfileController::class, 'updatePassword'])->name('updatePassword');
Route::get('/changeBalance', [ProfileController::class, 'changeBalance'])->name('profile\changeBalance');
Route::put('/updateBalance', [ProfileController::class, 'updateBalance'])->name('updateBalance');

// Deactivated User
Route::get('/deactivated', function () {
    return view('admin.deactivated');
})->name('deactivated');


// 403 Page
Route::get('/403', function () {
    return view('admin.403');
})->name('403');