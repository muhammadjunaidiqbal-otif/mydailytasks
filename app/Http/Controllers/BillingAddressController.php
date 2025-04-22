<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use Illuminate\Support\Facades\Auth;

class BillingAddressController extends Controller
{
    public function addBillingInfo(Request $request){
    $request->validate([
        'first_name'   => 'required|string|max:255',
        'last_name'    => 'required|string|max:255',
        'company_name' => 'nullable|string|max:255',
        'country_id'   => 'required|exists:countries,id',
        'address'      => 'required|string|max:500',
        'state_id'     => 'required|exists:states,id',
        'city_id'      => 'required|exists:cities,id',
        'postal_code'  => 'required|string|max:20',
        'phone'        => 'required|string|max:20',
        'email'        => 'required|email|max:255',
        'description'  => 'nullable|string|max:500',
        ]);
        
        $billingAddress = BillingAddress::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_name'=>$request->company_name,
            'address'=>$request->address,
            'country_id'=>$request->country_id,
            'state_id'=>$request->state_id,
            'city_id'=>$request->city_id,
            'postal_code'=>$request->postal_code,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'description'=>$request->description,
            'created_at'=>now(),
            'updated_at'=>null
        ]);

            $order = Orders::create([
                'user_id'=>null,
                'billing_id'=>$billingAddress->id,
                'cart'=>$request->input('cart'),
                'total'=>$request->input('total'),
                'discount'=>$request->input('discount', 0),
                'status'=>'pending',
                'payment_status'=>'pending'
            ]);
            if(!($billingAddress&&$order)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'An error occurred while creating the product.',
                    'error' => $e->getMessage()
                ], 500);
            }
            $successURL = route('order.success').'?session_id={CHECKOUT_SESSION_ID}&order_id='.$order->id;
            
            $stripe = new StripeClient(env('STRIPE_SECRET'));
            $session = $stripe->checkout->sessions->create([
              'success_url' => $successURL,
              'customer_email'=>$billingAddress->email,
              'line_items' => [
                [
                  'price_data' => [
                        'product_data'=>[
                            'name'=>'shopping',
                        ],
                        'unit_amount' => intval($order->total * 100),
                        'currency'=>'USD'
                  ],
                  'quantity' => 2,
                ],
              ],
              'mode' => 'payment',
            ]);
            //dd($session);
            return response()->json(['url' => $session['url']]);
    }
    public function orderSuccess(Request $request){
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve(
                    $request->session_id,
                []
            );
       //dd($session);
       if($session->status=="complete"){
        $order = Orders::find($request->order_id);

        $order->payment_status = "paid";
        $order->save();
        
        session()->forget('cart');
        return view('Users.invoice', [
            'order_id' => $request->order_id
        ]);
       }     
    }
}
