<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle(){
        Log::info('Redirecting to Google with URI: ' . env('GOOGLE_REDIRECT_URI'));
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt('default_password')
                ]
            );
            $user = Auth::login($user);
            $logedInUser = Auth::user();
            if ($logedInUser->role_id == 1) {
                return redirect()->route('user-Dashboard')->with('status', 'Login Successfully :)');
            } else {
                return redirect()->route('users-home-page')->with('status', 'Login Successfully :)');
            }
        } catch (Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Google authentication failed.']);
        }
    }
}
