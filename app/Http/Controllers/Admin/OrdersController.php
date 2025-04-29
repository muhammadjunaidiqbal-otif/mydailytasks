<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function pendingOrders(){
    $orders = Orders::with('billingAddress')
        ->where('status', 'pending')
        ->where('user_id',Auth::user()->id)
        ->orderByDesc('created_at')
        ->get();

    return view('Users.pending-order', compact('orders'));
    }
    public function ordersListPage(){
        $orders = Orders::all();
        return view('Admin.Orders.orders-list',compact('orders'));
    }
    public function ordersList(){
        $orders = Orders::with('user')->where('user_id','!=',null)->orderBy('id','asc')->get();
        return response()->json([
            'info'=>$orders
        ]);
    }
    public function orderDetail($id){
        $order = Orders::with(['billingAddress.country', 'billingAddress.state', 'billingAddress.city'])
        ->find($id);
        //return $order;
        return view('Admin.Orders.order-details',compact('order'));
    }
    public function cartDetails($id){
        $order = Orders::find($id);
        $cart = json_decode($order->cart, true);
        $cartItems = array_values($cart);
        return response()->json(['info'=>$cartItems]);
    }

}
