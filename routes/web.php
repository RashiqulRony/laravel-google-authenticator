<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TwoFactorMiddleware;
use App\Http\Controllers\TwoFactorController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/2fa/enable', [TwoFactorController::class, 'enableTwoFactor'])->name('2fa.enable');
Route::post('/2fa/verify', [TwoFactorController::class, 'verifyTwoFactor'])->name('2fa.verify');

Route::group(['middleware' => [TwoFactorMiddleware::class]], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});


