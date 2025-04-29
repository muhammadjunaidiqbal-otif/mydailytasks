<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHomePage(){
        return view('Ecom.home');
    }
    public function showProductPage() {
        return view('Ecom.product');
    }
    public function showCartPage() {
        return view('Ecom.cart');
    }
    public function showAboutUsPage() {
        return view('Ecom.about');
    }
    public function showContactUsPage() {
        return view('Ecom.contact');
    }
    public function clearCartSession() {
        session()->forget('cart'); // or session()->flush();
        return 'Session cleared!';
    }
}
