<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PartnerRoleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/test', function () {
    return "Hello";
});



Route::get('/', function () {
    return view('login');
})->name('login.page');
Route::get('/register-page', [UserController::class,'ShowRegisterPage'])->name('register.page');
Route::get('/reset-page', function () {
    return view('forgetpass');
})->name('reset.page');
Route::post('/register-user',[UserController::class,'register'])->name('newuser.register');


Route::post('/login-user',[UserController::class,'login'])->name('login.user');
Route::get('/logout',[UserController::class,'logout'])->name('logout');
Route::get('/users-details',[UserController::class,'users'])->name('user.index');


Route::post('/reset-page',[UserController::class,'resetpass'])->name('pass.reset');
Route::get('/email',[UserController::class,'mail'])->name('send.email');
Route::get('/reset-pass/{token}',[UserController::class,'resetpassform'])->name('reset.pass');
Route::post('/submit-reset-pass',[UserController::class,'submitresetpassword'])->name('sumbit.resetpass');

Route::get('/email-verification',function(){
    return view('emailverification');
})->name('verification.page');

Route::get('/dashboard',[UserController::class,'dashboard'])->name('dashboard')->middleware('verified.user');

Route::post('/send-mail',[UserController::class,'resendmail'])->name('mail.send');
Route::get('/verify-email/{id}',[UserController::class,'verifyemail'])->name('verify.email');
Route::post('/verified-email',[UserController::class,'verifiedemail'])->name('verified.mail');




//The Email Verification Notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
//The Email Verification Handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/dashboard')->route('dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');
//Resending the Verification Email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



//fetch-cities
Route::get('/fetch-countries', [ApiController::class, 'fetchCountries']);
Route::get('/fetch-states', [ApiController::class, 'fetchStates']);
Route::get('/fetch-cities', [ApiController::class, 'fetchCities']);
//test route
Route::get('/countries-details',[CountryController::class,'GetCountries']);
Route::get('/cities-details',[CityController::class,'GetCities']);

Route::get('/states-details',[StateController::class,'GetStates']);

Route::get('/states-details',[StateController::class,'GetStates']);
Route::get('/country-users',[CountryController::class,'users']);

Route::get('/country-states',[CountryController::class,'getstates']);


Route::get('/get-states/{country_id}',[StateController::class,'StatesForCountry']);
Route::get('/get-cities/{state_id}',[CityController::class,'CitiesforState']);


Route::get('/test-page',function(){
    return view('Admin.test-dashboard');
})->name('test.dashboard')->middleware('verified.user');
Route::get('/test-calender',function(){
    return view('Admin.calender');
})->name('calender.page')->middleware('verified.user');
Route::get('/test-profile',function(){
    return view('Admin.user-profile');
})->name('user.profile')->middleware('verified.user');


Route::resource('/roles',RoleController::class);

Route::resource('/partners',PartnerRoleController::class);
