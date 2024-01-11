<?php

use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::post('google/callback', [Triptasoft\Laravo\Http\Controllers\Auth\SocialiteController::class, 'callback']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('count/{any}', ['uses' => 'Triptasoft\Laravo\Http\Controllers\LaravoController@count']);
    Route::get('chart/{any}', ['uses' => 'Triptasoft\Laravo\Http\Controllers\LaravoController@chart']);
});