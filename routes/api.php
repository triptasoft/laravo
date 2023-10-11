<?php

use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::post('google/callback', [Triptasoft\Laravo\Http\Controllers\Auth\SocialiteController::class, 'callback']);
});