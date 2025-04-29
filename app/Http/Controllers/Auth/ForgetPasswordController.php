<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\TestMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    public function passResetRequest(){
        return view('Auth.forgetpass');
    }
    public function verifyEmail(Request $request){
        //return $request;
        $user = User::where('email', $request->email)->first();
        //return $user;
        if($user){
            return view('Auth.forgetpass',['email'=>$user->email]);
        }else{
            return back()->with('error','Not A Valid Email');
        }
    }
    public function emailForResetPassword(Request $request){
        $token =  str::random(64);
        DB::table('password_reset_tokens')->where('email',$request->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>now()
        ]);
        $name = User::where('email',$request->email)->get();
        //return $name[0]['name'];
        $data = ['name' => $name[0]['name'],
                  'token'=>$token,
                  'email'=>$request->email
        ];
        Mail::to('junaidiqbalmrar@gmail.com')->send(new TestMail($data));
        return redirect()->route('login-page')->with('status','Reset Pass Mail Send Successfully');
    }
    public function resetPassForm($token){
        $email = DB::table('password_reset_tokens')->where('token',$token)->first();
        //return $email->email;
        if($email){
            return view('Auth.resetpass',
                            [
                                'token' => $token,
                                'email'=>$email->email
                            ]);
        }else{
            return "You Dont Have Any Password Reset Request";
        }

    }
    public function resetPassword(Request $request){
    
        $request->validate([            
            'password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',        // At least one uppercase letter
                'regex:/[a-z]/',        // At least one lowercase letter
                'regex:/[0-9]/',        // At least one number
            ],    // At least one special character,
            'confirm-pass' => 'required|same:password'
        ]);
        //return $request;
        $updatepassword = DB::table('password_reset_tokens')->where(['email'=>$request->email,'token'=>$request->token])->first();
        //return $updatepassword;
        if(!$updatepassword){
            return back()->with('status','Invalid Token');
        }else{
            User::where('email',$request->email)->update([
                'password'=>Hash::make($request->password),
                'updated_at'=>now()
            ]);
            DB::table('password_reset_tokens')->where(['email'=>$request->email,'token'=>$request->token])->delete();
            return redirect()->route('login-page')->with('status','Password Updated Successfully!');
        }
    }
}
