<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
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
        $orders = Orders::with('user')->where('user_id','!=',null)->get();
        return response()->json([
            'info'=>$orders
        ]);
    }
    public function orderDetail(){
        return view('Admin.Orders.order-details');
    }

}
