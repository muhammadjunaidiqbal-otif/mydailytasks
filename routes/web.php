<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\Ecom\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PartnerRoleController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Ecom\EcomShopController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Ecom\BillingAddressController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\EmailVerificationController;

Route::get('/test', function () {
    return view('welcome');
});
//Authentication Routes 
//LoginController
Route::get('/login', [LoginController::class,'loginPage'])->name('login-page');
Route::post('/login',[LoginController::class,'login'])->name('user-login');
Route::get('/logout',[LoginController::class,'logout'])->name('user-logout');
//RegisterController
Route::get('/register-page',[RegisterController::class,'ShowRegisterPage']);
Route::post('/register',[RegisterController::class,'register'])->name('user-register');
//ForgetPasswordController
Route::get('/forget-pass',[ForgetPasswordController::class,'passResetRequest'])->name('forget-pass');
Route::post('/verify-email',[ForgetPasswordController::class,'verifyEmail'])->name('verifyemail');
Route::get('/email',[ForgetPasswordController::class,'emailForResetPassword'])->name('send.email');
Route::get('/reset-pass/{token}',[ForgetPasswordController::class,'resetpassform'])->name('reset.pass');
Route::post('/submit-reset-pass',[ForgetPasswordController::class,'resetPassword'])->name('sumbit.resetpass');
//EmailVerificationController->Laravel Default Email Verification
//The Email Verification Notice
Route::get('/email/verify', [EmailVerificationController::class,'showVerificationNotice'])->middleware('auth')->name('verification.notice');
//The Email Verification Handler
Route::get('/email/verify/{id}/{hash}',[EmailVerificationController::class,'emailVerificationHandler'])->middleware(['auth', 'signed'])->name('verification.verify');
//Resending the Verification Email
Route::post('/email/verification-notification',[EmailVerificationController::class,'resendVerificationEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/verified-email',[EmailVerificationController::class,'verifiedemail'])->name('verified.mail');

//Admin Routes
//DashBoardController->Index.HtmlPage
Route::get('/index.html',[DashBoardController::class,'showIndexPage'])->name('user-Dashboard');
Route::get('/calender',[DashBoardController::class,'showCalenderPage'])->name('calender.page');
Route::get('/profile',[DashBoardController::class,'showProfilePage'])->name('user.profile');
Route::get('/user-datatable',[DashBoardController::class,'showUserDataTablePage'])->name('users.datatable');
//UserController->DataTable->Users
Route::get('/users/data',[UserController::class,'index'])->name('users.data');
Route::delete('/user/delete/{id}',[UserController::class,'delete'])->name('user.delete');
Route::post('/user/update',[UserController::class,'update'])->name('user.update');
Route::post('/delete-selectedusers',[UserController::class,'deleteSelectedRows'])->name('delete-selected');
Route::post('/create-record',[UserController::class,'storeUser'])->name('create-record');
//CategoryController->category-list page
Route::get('/products-category',[CategoryController::class,'showCategoriesPage'])->name('products-category-list');
Route::get('/categories/data',[CategoryController::class,'index'])->name('categories.data');
Route::post('/categories/submit',[CategoryController::class,'store'])->name('categories-store');
Route::resource('/categories',CategoryController::class);
Route::get('/category-update/{id}',[CategoryController::class,'show'])->name('categories-update');
Route::post('/category/edit',[CategoryController::class,'edit'])->name('category.edit');
Route::post('/delete-selectedcategories',[CategoryController::class,'deleteSelectedRows'])->name('delete-selected-categories');
//ProductController->products-add/List page
Route::get('/products',[ProductController::class,'showProductsListPage'])->name('products-list');
Route::get('/products/add',[ProductController::class,'create'])->name('add-products');
Route::post('/product/store',[ProductController::class,'store'])->name('store-products');
Route::get('/products/list',[ProductController::class,'index'])->name('list-products');
Route::delete('/product/delete/{id}',[ProductController::class,'destroy'])->name('delete-product');
Route::get('/product/edit/{id}',[ProductController::class,'edit'])->name('edit-product');
Route::post('/product/update/{id}',[ProductController::class,'update'])->name('update-product');
Route::post('/delete-selectedproducts',[ProductController::class,'deleteSelectedRows'])->name('delete-selected-products'); 
Route::get('/load-products', [ProductController::class, 'loadProducts'])->name('load.products');
Route::post('/products/sale-end', [ProductController::class, 'updateSaleEnd'])->name('add-products-saleEnd');
//OrderController->OrdersList/Detail Page 
Route::get('/orders-list-page',[OrdersController::class,'ordersListPage'])->name('orders-list-page');
Route::get('/orders/list',[OrdersController::class,'ordersList'])->name('orders-list');
Route::get('/order/details/{id}',[OrdersController::class,'orderDetail'])->name('order-detail');
Route::get('/cart/details/{id}',[OrdersController::class,'cartDetails'])->name('cartDetailsForOrderId');

//EcomController
//User-Dashboards Routes
Route::get('/',[HomeController::class,'showHomePage'])->name('users-home-page');
Route::get('/shop', [EcomShopController::class,'showProducts'])->name('users-shop-page');
Route::get('/laod-products', [EComShopController::class, 'getProducts'])->name('shop.load.products');
Route::get('/product',[HomeController::class,'showProductPage'] )->name('users-product-page');
Route::get('/cart',[HomeController::class,'showCartPage'] )->name('users-cart-page');
Route::get('/about-us',[HomeController::class,'showAboutUsPage'] )->name('users-about-page');
Route::get('/contact',[HomeController::class,'showContactUsPage'] )->name('users-contact-page');
Route::get('/clear-session',[HomeController::class,'clearCartSession']);
//cart page routes
Route::post('/cart/add', [EcomShopController::class, 'addToCart'])->name('add-to-cart');
Route::post('/cart/remove', [EcomShopController::class, 'removeFromCart'])->name('remove-from-cart');
Route::post('/update-cart-quantity', [EcomShopController::class, 'updateCartQuantity'])->name('update-cart-quantity');
//checkout page routes
Route::get('/check-out',[EcomShopController::class,'checkOutPage'])->name('users-checkout-page');
Route::post('/addBillingAddress',[BillingAddressController::class,'addBillingInfo'])->name('add-billing-info');
Route::get('/order-success',[BillingAddressController::class,'orderSuccess'])->name('order.success');
Route::get('/order/cancel', [BillingAddressController::class, 'orderCancel'])->name('order.cancel');
Route::get('/orders', [OrdersController::class, 'pendingOrders'])->name('orders.pending');
Route::post('/add-to-cart', [EcomShopController::class,'homeAddToCartBtn'])->name('cart.add');


//Test Routes

Route::get('/reset-page', function () {
    return view('forgetpass');
})->name('reset.page');
//Routes For Custom Email Verification
Route::post('/send-mail',[UserController::class,'resendmail'])->name('mail.send');
Route::get('/verify-email/{id}',[UserController::class,'verifyemail'])->name('verify.email');
Route::get('/email-verification',function(){
    return view('emailverification');
})->name('verification.page');

//fetch-cities-countries-states Routes From API's
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
Route::get('/get-states/{country_id}',[StateController::class,'StatesForCountry'])->name('states-for-countries');
Route::get('/get-cities/{state_id}',[CityController::class,'CitiesforState'])->name('cities-for-states');
//simpledatatable routes
Route::get('/data-table',function(){
    return view('Partners.datatables');
});
//Advancedatatable routes
Route::get('/advance-dt',function(){
    return view('Datatables.advance-dt');
});
//tempalte routes
Route::get('/test-page',function(){
    return view('Admin.test-dashboard');
})->name('test.dashboard')->middleware('verified.user');

//RolesAndPartnerRoleControllers
Route::resource('/roles',RoleController::class);
Route::resource('/partners',PartnerRoleController::class);
