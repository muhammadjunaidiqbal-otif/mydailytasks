<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EcomShopController;
use App\Http\Controllers\PartnerRoleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/test', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('auth.auth-login');
})->name('login-page');

Route::post('/login',[UserController::class,'login'])->name('user-login');
Route::get('/register-page',function(){
    return view('auth.auth-register');
});
Route::get('/reset-page', function () {
    return view('forgetpass');
})->name('reset.page');
Route::post('/register',[UserController::class,'register'])->name('user-register');


Route::post('/login-user',[UserController::class,'login'])->name('login.user');
Route::get('/logout',[UserController::class,'logout'])->name('user-logout');
Route::get('/forget-pass',function(){
    return view('auth.auth-forgetpass');
})->name('forget-pass');
Route::get('/users-details',[UserController::class,'users'])->name('user.index');


Route::post('/verify-email',[UserController::class,'verify_Email'])->name('verifyemail');
Route::get('/email',[UserController::class,'mail'])->name('send.email');
Route::get('/reset-pass/{token}',[UserController::class,'resetpassform'])->name('reset.pass');
Route::post('/submit-reset-pass',[UserController::class,'submitresetpassword'])->name('sumbit.resetpass');

Route::get('/email-verification',function(){
    return view('emailverification');
})->name('verification.page');

Route::get('/index.html',function(){
    return view('Dashboards.index');
})->name('user-Dashboard');

Route::post('/send-mail',[UserController::class,'resendmail'])->name('mail.send');
Route::get('/verify-email/{id}',[UserController::class,'verifyemail'])->name('verify.email');
Route::post('/verified-email',[UserController::class,'verifiedemail'])->name('verified.mail');




//The Email Verification Notice
Route::get('/email/verify', function () {
    return view('auth.auth-emailverification');
})->middleware('auth')->name('verification.notice');
//The Email Verification Handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect()->route('user-Dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');
//Resending the Verification Email
Route::post('/email/verification-notification', function (Request $request) {
    //dd(123);
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('status', 'Verification link sent again!');
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

//tempalte routes
Route::get('/test-page',function(){
    return view('Admin.test-dashboard');
})->name('test.dashboard')->middleware('verified.user');
Route::get('/test-calender',function(){
    return view('Dashboards.calender');
})->name('calender.page')->middleware('verified.user');
Route::get('/test-profile',function(){
    return view('Dashboards.user-profile');
})->name('user.profile')->middleware('verified.user');
Route::get('/users-datatable',function(){
    return view('Dashboards.dataTable');
})->name('users.datatable')->middleware('verified.user');


//
Route::resource('/roles',RoleController::class);

Route::resource('/partners',PartnerRoleController::class);


//simpledatatable routes
Route::get('/data-table',function(){
    return view('Partners.datatables');
});
Route::get('/advance-dt',function(){
    return view('Datatables.advance-dt');
});
Route::get('/users/data',[UserController::class,'index'])->name('users.data');
Route::delete('/user/delete/{id}',[UserController::class,'delete'])->name('user.delete');
Route::post('/user/update',[UserController::class,'update'])->name('user.update');
Route::post('/delete-selectedusers',[UserController::class,'deleteSelectedRows'])->name('delete-selected');
Route::post('/create-record',[UserController::class,'storeUser'])->name('create-record');

//Products Routes
//->category-list page
Route::get('/products-category',function(){
    return view('Products-view.products-categories');
})->name('products-category-list');
Route::get('/categories/data',[CategoryController::class,'index'])->name('categories.data');
Route::post('/categories/submit',[CategoryController::class,'store'])->name('categories-store');
Route::resource('/categories',CategoryController::class);
Route::get('/category-update/{id}',[CategoryController::class,'show'])->name('categories-update');
Route::post('/category/edit',[CategoryController::class,'edit'])->name('category.edit');
Route::post('/delete-selectedcategories',[CategoryController::class,'deleteSelectedRows'])->name('delete-selected-categories');

//->product-list page
Route::get('/products',function(){
   return view('Products-view.products-productslist');
})->name('products-list');

//->products-add page
Route::get('/products/add',[ProductController::class,'create'])->name('add-products');
Route::post('/product/store',[ProductController::class,'store'])->name('store-products');
Route::get('/products/list',[ProductController::class,'index'])->name('list-products');
Route::delete('/product/delete/{id}',[ProductController::class,'destroy'])->name('delete-product');
Route::get('/product/edit/{id}',[ProductController::class,'edit'])->name('edit-product');
Route::post('/product/update/{id}',[ProductController::class,'update'])->name('update-product');
Route::post('/delete-selectedproducts',[ProductController::class,'deleteSelectedRows'])->name('delete-selected-products'); 

//User-Dashboards Routes
Route::get('/home',function(){
    return view('Users.home');
})->name('users-home-page');

Route::get('/shop', [EcomShopController::class,'showProducts'])->name('users-shop-page');

Route::get('/product', function () {
    return view('Users.product');
})->name('users-product-page');

Route::get('/cart', function () {
    return view('Users.cart');
})->name('users-cart-page');

Route::get('/about-us', function () {
    return view('Users.about');
})->name('users-about-page');

Route::get('/contact', function () {
    return view('Users.contact');
})->name('users-contact-page');

Route::get('/clear-session', function () {
    session()->forget('cart'); // or session()->flush();
    return 'Session cleared!';
});

Route::post('/cart/add', [EcomShopController::class, 'addToCart'])->name('add-to-cart');
Route::post('/cart/remove', [EcomShopController::class, 'removeFromCart'])->name('remove-from-cart');
