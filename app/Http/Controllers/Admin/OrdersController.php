<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
    public function ordersList(Request $request){
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // Parse and log dates
            $start = Carbon::parse($request->start_date)->timezone(config('app.timezone'))->startOfDay();
            $end = Carbon::parse($request->end_date)->timezone(config('app.timezone'))->endOfDay();
    
            Log::info("Date Range applied", [
                'start_date' => $start->toDateTimeString(),
                'end_date' => $end->toDateTimeString()
            ]);
    
            $query = Orders::with('user')
                ->whereBetween('created_at', [$start, $end])
                ->orderBy('created_at', 'desc');
        } else {
            // Default: today’s records in app timezone
            $start = Carbon::now();
            $end = Carbon::now();
    
            $query = Orders::with('user')
                ->latest()
                ->orderBy('created_at', 'desc')
                ->limit(100);
    
            Log::info("Default today range applied", [
                'start_date' => $start->toDateTimeString(),
                'end_date' => $end->toDateTimeString()
            ]);
        }
    
        $orders = $query->get();
    
        $orders = $orders->map(function ($order) {
            $order->DT_RowId = 'row_' . $order->id;
            return $order;
        });
    
        return response()->json([
            'info' => $orders
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
