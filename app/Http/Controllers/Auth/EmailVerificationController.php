<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\EmailVerifyMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    public function showVerificationNotice() {
        return view('Auth.emailverification');
    }
    public function emailVerificationHandler(EmailVerificationRequest $request) {
        $request->fulfill();
        $context = request('context');
        if ($context === 'checkout') {
            return redirect()->route('users-checkout-page')->with('verified', true);
        }
        return redirect()->route('user-Dashboard')->with('verified', true);
    }
    public function resendVerificationEmail(Request $request) {
        //dd(123);
        $request->user()->sendEmailVerificationNotification(); 
        return back()->with('status', 'Verification link sent again!');
    }
    
    public function resendMail(Request $request){
        $user = User::where('email',$request->email)->first();
    
        $data=[ 'name'=>$user->name,
            'id'=>$user->id,
            'success'=>"Email Sent Again"
        ];
            Mail::to($user->email)->send(new EmailVerifyMail($data));
            return view('emailverification',['info'=>$data]);
    }
    public function verifiedemail(Request $request){
        // return $request;
        $user = auth()->user(); // Use logged-in user instead of searching by email
        if (!$user || !$user->hasVerifiedEmail()) {
            return back()->with('status', 'Sorry! You Are Not Verified');
        }
        if($user->role_id==1){
            return view('Admin.Dashboards.index')->with('status', 'Email Verified Successfully');
        }
        return redirect()->route('users-checkout-page');
    }
    public function verifyemail($id){
        //return $request->email;
        $user = User::where('id',$id)->first();

        $user->update(['email_verified_at'=>now()]);
        $data=[ 'name'=>$user->name,
                'email'=>$user->email,
                'success'=>"Email Verified !"
            ];

        return view('Admin.Dashboard',['info'=>$data]);

    } 
}
