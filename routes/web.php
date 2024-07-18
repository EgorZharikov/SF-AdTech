<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/offers', [OfferController::class, 'index'])->name('offers');
Auth::routes(['verify' => true]);
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
