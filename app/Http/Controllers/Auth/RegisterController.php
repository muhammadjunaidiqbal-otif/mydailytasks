<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function ShowRegisterPage(){
        $countries = Country::orderBy('name','asc')->get();
        return view('Auth.register',compact('countries'));
    }
    public function register(Request $request){
        //return $request;
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password' => [
        'required',
        'min:8','confirmed',
        'regex:/[A-Z]/',       
        'regex:/[a-z]/',        
        'regex:/[0-9]/'],
        //'country_id'=>'required|int',
        //'state_id'=>'required|int',
        //'city_id'=>'required|int'
        ]);


        $user = User::create($data);
        session(['verification_context' => 'register']);
        $user->sendEmailVerificationNotification(); 
        $user_info= ['email'=>$user->email,'password'=>$request->password];

        // $data=[ 'name'=>$user->name,
        //         'id'=>$user->id,
        //         'success'=>"Email Sent"
        // ];
        //return $user_info;

        if(Auth::attempt($user_info)){
           // Mail::to($user->email)->send(new EmailVerifyMail($data));
            return redirect()->route('verification.notice')->with('status','User Registered');
        }else{
            return "Not Login";
        }        
        
    }
}
