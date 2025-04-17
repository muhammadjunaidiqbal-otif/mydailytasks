<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class EcomShopController extends Controller
{
    public function showProducts(){

        $products = Product::with('category')->get();
        return view('Users.shop',compact('products'));
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
}
