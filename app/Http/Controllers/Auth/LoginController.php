<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginPage(){
        return view('Auth.login');
    }
    public function login(Request $request){
        $user = User::where('email',$request->email)->first();
        //return $user;
        $data=$request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        $remember = $request->has('remember');
        if(Auth::attempt($data,$remember)){
            $request->session()->regenerate();
            if($user->email_verified_at===null){
                    return redirect()->route('verification.notice')->with('error','Verify Your Email First To Login !');
                }if ($user->role_id == 1) {  // Assuming 1 is for admin
                    return redirect()->route('user-Dashboard')->with('status', 'Login Successfully :)');
                } else {
                    return redirect()->route('users-home-page')->with('status', 'Login Successfully :)');
                }
            } else {
                // If login fails, return back with an error
                return back()->with('error', 'Invalid Username or Password');
            }
    }
    public function logout(Request $request){
        //return $request;
        $user=Auth::user();
        if(isset($user->remember_token)){
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $user->setRememberToken(null);
            $user->save();
        }
        Auth::logout();
        return redirect()->route('login-page')->with('status','Logout Successfully . ');
    }
}
