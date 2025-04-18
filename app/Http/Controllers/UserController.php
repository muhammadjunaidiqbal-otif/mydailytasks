<?php

namespace App\Http\Controllers;

use ajax;
use App\Models\City;
use App\Models\User;
use App\Mail\TestMail;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EmailVerifyMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function users(){
        $users = User::all();
        return $users;
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
                }else{
                    return redirect()->route('user-Dashboard')->with('status','Login Successfully ;)');
                }
            
        }else{
            return back()->with('error','Invalid Username or Password');
        }
    }
    public function dashboard(){
        if(Auth::check()){
            return view('test.dashboard');
        }else{
            return redirect()->route('login.page');
        }  
    } 
    public function ShowRegisterPage(){
        $countries = Country::orderBy('name','asc')->get();
        return view('register',compact('countries'));
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

    public function verify_Email(Request $request){
        //return $request;
        $user = User::where('email', $request->email)->first();
        //return $user;
        if($user){
            return view('auth.auth-forgetpass',['email'=>$user->email]);
        }else{
            return back()->with('error','Not A Valid Email');
        }
    }

    public function mail(Request $request)
    {
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
    public function resetpassform($token)
    {
        $email = DB::table('password_reset_tokens')->where('token',$token)->first();
        //return $email->email;
        if($email){
            return view('auth.auth-resetpass', ['token' => $token,
                                  'email'=>$email->email
                                ]);
        }else{
            return "You Dont Have Any Password Reset Request";
        }

    }

    public function submitresetpassword(Request $request){
    
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
            'password'=>Hash::make($request->password)
        ]);
        DB::table('password_reset_tokens')->where(['email'=>$request->email,'token'=>$request->token])->delete();
        return redirect()->route('login-page')->with('status','Password Updated Successfully!');
    }
    

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
    public function resendmail(Request $request){
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
            $user =  User::where('email',$request->email)->first();
            if($user->email_verified_at===null){
                return view('auth.verify-email')->with('status','Sorry! You Are Not Verified');
                }else{
                    return view('Dashboards.index')->with('status','Email Verified Successfully');     
                }
         }   
    public function index(Request $request)
    {
       // sleep(60);
        $partners =  User::with('role')->get();
        return response()->json([
            'info' => $partners
        ]);
          
    }
    //return $data;
    public function delete($id){
        $user = User::find($id); // Corrected query

        if (!$user) {
            return response()->json(['error' => 'User not found!'], 404);
        }
    
        $user->delete();
    
        return response()->json(['msg' => 'User deleted successfully!']); 
    
    } 
    public function update(Request $request){
    $user = User::find($request->id);
    if (!$user) {
        return response()->json(['error' => 'User not found']);
    }

    // Update user fields
    $user->name = $request->name;
    $user->email = $request->email;
    $user->role_id=$request->role;
    $user->save();

    return response()->json(['success' => 'User updated successfully']);
    }   

    public function deleteSelectedRows(Request $request){
        $ids = $request->ids; 
        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Records deleted successfully!']);
        }
        return response()->json(['error'=> 'No records selected.'], 400);
    }

    public function storeUser(Request $request){
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password' => [
        'required',
        'min:8',
        'regex:/[A-Z]/',       
        'regex:/[a-z]/',        
        'regex:/[0-9]/'],
        ]);
        $user = User::create($data);
        if($user){
            return response()->json(['success' => 'Records Created successfully']);
        }
        return response()->json(['error' => 'Error Creating Record'], 400);
    }

}




