<?php

namespace Triptasoft\Laravo\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{

    public function __construct()
    {
        // Retrieve the Google client secret from the configuration and store it as a property
        Config::set('services.google.client_id', setting('google-auth.google_client_id'));
        Config::set('services.google.client_secret', setting('google-auth.google_client_secret'));
        Config::set('services.google.redirect', setting('google-auth.google_redirect'));
    }
    
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        if ($request->isMethod('get')) {
            $google = Socialite::driver('google')->user();
        } elseif ($request->isMethod('post')) {
            $google = Socialite::driver('google')->userFromToken($request->access_token);
        }
        $role   = Role::where('name', '=', config('voyager.user.default_role'))->first();

        $request->merge([
            'email' => $google->getEmail(),
            'password' => $google->getId(),
        ]);

        $user = User::query()
            ->where('provider_id', $google->getId())
            ->first();

        if ($user !== null) {
            if ($request->isMethod('get')) {
                return $this->login($user, 'Successfully logged in.');
            } elseif ($request->isMethod('post')) {
                return $this->token($request);
            }
        }

        $user = User::query()
                ->where('email', $google->getEmail())
                ->first();

        if ($user !== null) {
            $user->update([
                'provider_id' => $google->getId(),
            ]);
            if ($request->isMethod('get')) {
                return $this->login($user, 'Successfully logged in.');
            } elseif ($request->isMethod('post')) {
                return $this->token($request);
            }
        }

        $user = User::query()->create([
            'provider_id'   => $google->getId(),
            'email'         => $google->getEmail(),
            'name'          => $google->getName(),
            'password'      => bcrypt($google->getId()),
            'username'      => substr($google->getEmail(), 0, strpos($google->getEmail(), '@')),
            'role'          => $role->id,
        ]);

        event(new Registered($user));

        if ($request->isMethod('get')) {
            return $this->login($user, 'Thanks for signing up!');
        } elseif ($request->isMethod('post')) {
            return $this->token($request);
        }
    }

    private function login($user, $message) {
        auth()->guard()->login($user, false);

        return redirect()->route('voyager.dashboard');
    }

    private function token($request) {
        $api = new \Joy\VoyagerApiAuth\Http\Controllers\VoyagerAuthController();
        return $api->login($request);
    }
}
