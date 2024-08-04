<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AdvertiserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WebmasterController;

Auth::routes(['verify' => true]);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('checkBanned')->group(function () {
Route::get('/offers', [OfferController::class, 'index'])->name('offer.index');
Route::get('/offers/create', [OfferController::class, 'create'])->name('offer.create');
Route::post('/offers', [OfferController::class, 'store'])->middleware('checkWalletBalance')->name('offer.store');
Route::patch('/offers/{offer}', [OfferController::class, 'update'])->middleware('checkWalletBalance')->name('offer.update');
Route::patch('/offers/{offer}/unpublish', [OfferController::class, 'unpublish'])->middleware('advertiser')->name('offer.unpublish');
Route::patch('/offers/{offer}/publish', [OfferController::class, 'publish'])->middleware('advertiser')->name('offer.publish');
Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offer.show');
Route::post('/offers/{offer}/subscriptions', [SubscriptionController::class, 'store'])->middleware('webmaster')->name('offer.subscription.store');
Route::get('/offers/{offer}/edit', [OfferController::class, 'edit'])->name('offer.edit');
Route::delete('/offers/{offer}/subscriptions', [SubscriptionController::class, 'destroy'])->middleware('webmaster')->name('offer.subscription.destroy');
Route::get('/redirect/{referal_link}', [RedirectController::class, 'redirect'])->middleware('subscribed')->name('redirect');

Route::patch('/wallet', [WalletController::class, 'update'])->middleware('verified')->name('wallet.update');
// Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscription.store');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified', 'dashboard')->name('dashboard');

Route::get('/webmaster', [WebmasterController::class, 'index'])->middleware('verified', 'webmaster')->name('dashboard.webmaster.index');
Route::get('/webmaster/profile', [WebmasterController::class, 'profile'])->middleware('verified', 'webmaster')->name('dashboard.webmaster.profile');
Route::get('/webmaster/subscriptions', [WebmasterController::class, 'subscriptions'])->middleware('verified', 'webmaster')->name('dashboard.webmaster.subscriptions');
Route::get('/webmaster/statistics', [WebmasterController::class, 'statistics'])->middleware('verified', 'webmaster')->name('dashboard.webmaster.statistics');
Route::post('/webmaster/statistics', [WebmasterController::class, 'statistics'])->middleware('verified', 'webmaster')->name('dashboard.webmaster.statistics');
Route::get('/webmaster/wallet', [WebmasterController::class, 'wallet'])->middleware('verified', 'webmaster')->name('dashboard.webmaster.wallet');

Route::get('/advertiser', [AdvertiserController::class, 'index'])->middleware('verified', 'advertiser')->name('dashboard.advertiser.index');
Route::get('/advertiser/profile', [AdvertiserController::class, 'profile'])->middleware('verified', 'advertiser')->name('dashboard.advertiser.profile');
Route::get('/advertiser/offers', [AdvertiserController::class, 'offers'])->middleware('verified', 'advertiser')->name('dashboard.advertiser.offers');
Route::get('/advertiser/statistics', [AdvertiserController::class, 'statistics'])->middleware('verified', 'advertiser')->name('dashboard.advertiser.statistics');
Route::post('/advertiser/statistics', [AdvertiserController::class, 'statistics'])->middleware('verified', 'advertiser');
Route::get('/advertiser/wallet', [AdvertiserController::class, 'wallet'])->middleware('verified', 'advertiser')->name('dashboard.advertiser.wallet');

Route::get('/administrator', [AdministratorController::class, 'index'])->middleware('verified', 'administrator')->name('dashboard.administrator.index');
Route::get('/administrator/profile', [AdministratorController::class, 'profile'])->middleware('verified', 'administrator')->name('dashboard.administrator.profile');
Route::get('/administrator/users', [AdministratorController::class, 'userList'])->middleware('verified', 'administrator')->name('dashboard.administrator.users.index');
Route::patch('/administrator/users/{user}', [AdministratorController::class, 'updateUser'])->middleware('verified', 'administrator')->name('dashboard.administrator.users.update');
Route::get('/administrator/users/create', [AdministratorController::class, 'createUser'])->middleware('verified', 'administrator')->name('dashboard.administrator.users.create');
Route::post('/administrator/users/create', [AdministratorController::class, 'storeUser'])->middleware('verified', 'administrator')->name('dashboard.administrator.users.store');
Route::get('/administrator/statistics', [AdministratorController::class, 'statistics'])->middleware('verified', 'administrator')->name('dashboard.administrator.statistics');
Route::post('/administrator/statistics', [AdministratorController::class, 'statistics'])->middleware('verified', 'administrator');
Route::get('/administrator/wallet', [AdministratorController::class, 'wallet'])->middleware('verified', 'administrator')->name('dashboard.administrator.wallet');
});