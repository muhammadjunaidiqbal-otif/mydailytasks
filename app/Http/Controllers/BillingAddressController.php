<?php

namespace App\Http\Controllers;

use App\Models\Orders;
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
            

        if ($billingAddress&&$order) {
            session()->forget('cart');
            return response()->json("Billing And Order created successfully");
        } else {
            return response()->json("Billing address creation failed", 500);
        }
    }
}
