<?php
Route::get('/', function () {
    return view('laravo::voyager.login');
});

Route::group(['prefix' => 'admin'], function () {
	Route::group(['as' => 'voyager.'], function () {
		$vnamespacePrefix = '\\'.config('voyager.controllers.namespace').'\\';
		$namespacePrefix = '\\'.'Triptasoft\Laravo\Http\Controllers'.'\\';

		Route::get('login', ['uses' => $vnamespacePrefix.'VoyagerAuthController@login',     'as' => 'login']);
    	Route::post('login', ['uses' => $vnamespacePrefix.'VoyagerAuthController@postLogin', 'as' => 'postlogin']);
		
		// Main Admin and Logout Route
		Route::get('/', ['uses' => $namespacePrefix.'LaravoController@index',   'as' => 'dashboard']);
		Route::post('logout', ['uses' => $namespacePrefix.'LaravoController@logout',  'as' => 'logout']);
		// Database Routes
		Route::resource('database', $namespacePrefix.'LaravoDatabaseController');
		
	});
	
});

Route::group(['as' => 'laravo.'], function () {
	$namespacePrefix = '\\'.'Triptasoft\Laravo\Http\Controllers'.'\\';
	//Asset Routes
	Route::get('laravo-assets', ['uses' => $namespacePrefix.'LaravoController@assets', 'as' => 'laravo_assets']);

	// Socialite auth
	Route::middleware('guest')->group(function () {
		Route::get('auth/google/redirect', [Triptasoft\Laravo\Http\Controllers\Auth\SocialiteController::class, 'redirect'])->name('google.redirect');
		Route::get('auth/google/callback', [Triptasoft\Laravo\Http\Controllers\Auth\SocialiteController::class, 'callback'])->name('google.callback');
		// Route::match(['get', 'post'], 'auth/google/callback', [Triptasoft\Laravo\Http\Controllers\Auth\SocialiteController::class, 'callback'])->name('google.callback');
	});
});