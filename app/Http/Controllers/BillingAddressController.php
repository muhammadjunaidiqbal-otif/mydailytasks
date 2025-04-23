<?php

namespace App\Http\Controllers;

use Stripe\Webhook;
use App\Models\User;
use App\Models\Orders;
use App\Models\Country;
use Stripe\StripeClient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use UnexpectedValueException;
use App\Models\BillingAddress;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Stripe\Exception\SignatureVerificationException;

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
        if (!Auth::check()) {
            $user = User::where('email', $request->email)->first();
            if ($request->has('create_account')) {
                if (!$user) {
                    $randomPassword = Str::random(8);
                    $user = User::create([
                        'name'       => $request->first_name . ' ' . $request->last_name,
                        'email'      => $request->email,
                        'password'   => Hash::make($randomPassword),
                        'country_id' => $request->country_id,
                        'state_id'   => $request->state_id,
                        'city_id'    => $request->city_id,
                        'role_id'    => 2,
                    ]);
                }
            }
            if ($user) {
                Auth::login($user);
            }
        }
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
                'user_id'=>$user->id,
                'billing_id'=>$billingAddress->id,
                'cart'=>$request->input('cart'),
                'total'=>$request->input('total'),
                'discount'=>$request->input('discount', 0),
                'status'=>'pending',
                'payment_status'=>'pending'
            ]);
            
            
            $successURL = route('order.success').'?session_id={CHECKOUT_SESSION_ID}&order_id='.$order->id;
            $cancelURL = route('order.cancel') . '?order_id=' . $order->id;
            $stripe = new StripeClient(env('STRIPE_SECRET'));
            $session = $stripe->checkout->sessions->create([
              'success_url' => $successURL,
              'cancel_url'=> $cancelURL , 
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
            $order->stripe_session_id = $session->id;
            $order->stripe_response = json_encode($session); // Store the full response
            $order->save();
            //dd($session);
            return response()->json(['url' => $session['url']]);
    }
    public function orderSuccess(Request $request){
        //dd($request->all());
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve(
                    $request->session_id,
                []
            );
       //dd($session);
       if ($session->payment_status === 'paid') {
        $order = Orders::find($request->order_id);
        $order->payment_status = 'paid';
        $order->status = 'success';
        $order->save();

        session()->forget('cart');

        return view('Users.invoice', [
            'order' => $order,
            'billing' => $order->billingAddress,
        ]);
    } else {
        return redirect()->route('order.cancel', ['order_id' => $order->id])
                         ->with('error', 'Payment not completed.');
    }
           
    }
    public function orderCancel(Request $request){
        $order = Orders::findOrFail($request->order_id);
        $order->status = 'failed';
        $order->payment_status = 'unpaid';
        $order->save();
        
        return redirect()->route('users-checkout-page');
    }
    public function handleWebhook(Request $request){
        //dd($request->all());
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET');
    
        Log::info('Webhook Payload:', ['raw' => $payload]);
    
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (UnexpectedValueException $e) {
            Log::error('Invalid Stripe payload: ' . $e->getMessage());
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            Log::error('Invalid Stripe signature: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }
    
        Log::info('Stripe Webhook Event Received', ['type' => $event->type]);
    
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $order = Orders::where('stripe_session_id', $session->id)->first();
                if ($order) {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'success',
                        'stripe_response' => json_encode($event),
                    ]);
                    Log::info('Order marked as paid', ['order_id' => $order->id]);
                }
                break;
    
            case 'checkout.session.expired':
                $session = $event->data->object;
                $order = Orders::where('stripe_session_id', $session->id)->first();
                if ($order) {
                    $order->update([
                        'payment_status' => 'unpaid',
                        'status' => 'failed',
                        'stripe_response' => json_encode($event),
                    ]);
                    Log::info('Order marked as failed', ['order_id' => $order->id]);
                }
                break;
    
            default:
                Log::warning('Unhandled Stripe event type: ' . $event->type);
                break;
        }
    
        return response('Webhook handled', 200);    
    }

}
