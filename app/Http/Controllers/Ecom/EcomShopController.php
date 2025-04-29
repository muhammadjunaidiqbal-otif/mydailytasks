<?php

namespace App\Http\Controllers\Ecom;

use App\Models\Country;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class EcomShopController extends Controller
{   
    public function showProducts(){
        sleep(1);
        $products = Product::with('category')->get();
        return view('Ecom.shop',compact('products'));
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
        return view('Ecom.checkout',compact('products','countries')) ;
    }   

    public function homeAddToCartBtn(Request $request){
        //return $request;
        Log::info('Add to Cart Request', $request->all());
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
    return response()->json([
        'Success'=>"Product Added To Cart Successfully",
        'cart'=>$cart
        ]);
    }
}
