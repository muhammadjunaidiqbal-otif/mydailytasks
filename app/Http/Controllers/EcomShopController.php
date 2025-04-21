<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use Illuminate\Http\Request;

class EcomShopController extends Controller
{
    public function showProducts(){
        sleep(1);
        $products = Product::with('category')->get();
        return view('Users.shop',compact('products'));
    }
    public function getProducts()
    {
    $products = Product::latest()->get();

    return response()->json(['products' => $products]);
    }
    public function test(){
        return "HI";
    }
    public function addToCart(Request $request)
    {
    //return $request;
    $product = Product::findOrFail($request->product_id);

    $cart = session()->get('cart', []);
    if(isset($cart[$product->id])) {
        $cart[$product->id]['quantity']++;
    } else {
        $cart[$product->id] = [
            "id"=>$product->id,
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->base_price,
            "image" => $product->image
        ];
    }
    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Product added to cart!');
    }
    public function removeFromCart(Request $request)
    {
    $cart = session('cart', []);
    if (isset($cart[$request->product_id])) {
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);
    }
    return redirect()->back()->with('success', 'Item removed from cart.');
    }
    public function updateCartQuantity(Request $request){
    $cart = session('cart', []);
    if (isset($cart[$request->product_id])) {
        $cart[$request->product_id]['quantity'] = $request->quantity;
        session(['cart' => $cart]);
    }

    return response()->json(['success'=>true]);
    }

    public function checkOutPage(){
        $products = session('cart',[]);
        $countries = Country::orderBy('name','asc')->get();
        return view('Users.checkout',compact('products','countries')) ;
    }   
}
