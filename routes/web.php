<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/offers', [OfferController::class, 'index'])->name('offer.index');
Route::get('/offers/create', [OfferController::class, 'create'])->name('offer.create');
Route::post('/offers', [OfferController::class, 'store'])->name('offer.store');
Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offer.show');
Route::post('/offers/{offer}/subscriptions', [SubscriptionController::class, 'store'])->middleware('webmaster')->name('offer.subscription.store');
Route::delete('/offers/{offer}/subscriptions', [SubscriptionController::class, 'destroy'])->middleware('webmaster')->name('offer.subscription.destroy');
Route::get('/redirect/{referal_link}', [RedirectController::class, 'redirect'])->middleware('subscribed')->name('redirect');

Auth::routes(['verify' => true]);
// Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscription.store');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
Route::get('/dashboard/webmaster', [DashboardController::class, 'webmaster'])->middleware('verified')->name('dashboard.webmaster');
