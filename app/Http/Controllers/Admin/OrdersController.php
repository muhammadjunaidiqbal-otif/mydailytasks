<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\BillingAddress;
use App\Models\Category;
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
    
            //Log::info("Default today range applied", [
            //    'start_date' => $start->toDateTimeString(),
            //    'end_date' => $end->toDateTimeString()
            //]);
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
    public function showOrderReportPage(Request $request){

        $users = BillingAddress::orderBy('first_name', 'asc')->get();
        $categories = Category::orderBy('title', 'asc')->get();
        $products_items = Product::orderBy('name', 'asc')->get();

        $start = $request->start;
        $end = $request->end;
        $userId = $request->user_id;
        $categoryId = $request->category_id;
        $filterProductId = $request->product_id;

        $ordersQuery = Orders::where('payment_status', 'paid');

        if ($userId) {
            $ordersQuery->where('billing_id', $userId);
        }

        if ($start && $end) {
            $ordersQuery->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
        } else {
            $ordersQuery->whereDate('created_at', now());
        }

        $orders = $ordersQuery->orderBy('created_at', 'desc')->get();

        $dailyProductStats = [];

        foreach ($orders as $order) {
            $orderDate = Carbon::parse($order->created_at)->format('Y-m-d');
            $cart = json_decode($order->cart, true);

            if (is_array($cart)) {
                foreach ($cart as $item) {
                    if (isset($item['id'], $item['quantity'], $item['price'])) {
                        $cartProductId = $item['id'];
                        $quantity = (int) $item['quantity'];
                        $salePrice = (float) $item['price'];

                        if ($filterProductId && $cartProductId != $filterProductId) {
                            continue;
                        }

                        $product = Product::with('category')->find($cartProductId);

                        if (!$product || $product->purchase_price === null) {
                            continue;
                        }

                        if ($categoryId && $product->category_id != $categoryId) {
                            continue;
                        }

                        $purchasePrice = (float) $product->purchase_price;
                        $profit = ($salePrice - $purchasePrice) * $quantity;

                        if (!isset($dailyProductStats[$orderDate])) {
                            $dailyProductStats[$orderDate] = [];
                        }
                        if (!isset($dailyProductStats[$orderDate][$cartProductId])) {
                            $dailyProductStats[$orderDate][$cartProductId] = [
                                'quantity' => 0,
                                'profit' => 0,
                                'product' => $product
                            ];
                        }

                        $dailyProductStats[$orderDate][$cartProductId]['quantity'] += $quantity;
                        $dailyProductStats[$orderDate][$cartProductId]['profit'] += $profit;
                    }
                }
            }
        }
        $tableData = [];
        foreach ($dailyProductStats as $date => $products) {
            foreach ($products as $productId => $stats) {
                $product = $stats['product'];

                $tableData[] = [
                    'Date' => $date,
                    'Product' => $product->name,
                    'Category' => $product->category->title ?? 'Unknown Category',
                    'Total' => $stats['quantity'],
                    'Profit' => number_format($stats['profit'], 2),
                ];
            }
        }
       //dd($tableData);
        return view('Admin.Reports.orders-report',compact('users','categories','products_items','tableData'));
    }
    // public function showOrdersReport(Request $request){
    //     $start = $request->start;
    //     $end = $request->end;
    //     $userId = $request->user_id;
    //     $categoryId = $request->category_id;
    //     $filterProductId = $request->product_id;

    //     $ordersQuery = Orders::where('payment_status', 'paid');

    //     if ($userId) {
    //         $ordersQuery->where('billing_id', $userId);
    //     }

    //     if ($start && $end) {
    //         $ordersQuery->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
    //     } else {
    //         $ordersQuery->whereDate('created_at', now());
    //     }

    //     $orders = $ordersQuery->orderBy('created_at', 'desc')->get();

    //     $dailyProductStats = [];

    //     foreach ($orders as $order) {
    //         $orderDate = Carbon::parse($order->created_at)->format('Y-m-d');
    //         $cart = json_decode($order->cart, true);

    //         if (is_array($cart)) {
    //             foreach ($cart as $item) {
    //                 if (isset($item['id'], $item['quantity'], $item['price'])) {
    //                     $cartProductId = $item['id'];
    //                     $quantity = (int) $item['quantity'];
    //                     $salePrice = (float) $item['price'];

    //                     if ($filterProductId && $cartProductId != $filterProductId) {
    //                         continue;
    //                     }

    //                     $product = Product::with('category')->find($cartProductId);
    //                     if (!$product || $product->purchase_price === null) {
    //                         continue;
    //                     }

    //                     if ($categoryId && $product->category_id != $categoryId) {
    //                         continue;
    //                     }

    //                     $purchasePrice = (float) $product->purchase_price;
    //                     $profit = ($salePrice - $purchasePrice) * $quantity;

    //                     if (!isset($dailyProductStats[$orderDate])) {
    //                         $dailyProductStats[$orderDate] = [];
    //                     }

    //                     if (!isset($dailyProductStats[$orderDate][$cartProductId])) {
    //                         $dailyProductStats[$orderDate][$cartProductId] = [
    //                             'quantity' => 0,
    //                             'profit' => 0,
    //                             'product' => $product
    //                         ];
    //                     }

    //                     $dailyProductStats[$orderDate][$cartProductId]['quantity'] += $quantity;
    //                     $dailyProductStats[$orderDate][$cartProductId]['profit'] += $profit;
    //                 }
    //             }
    //         }
    //     }

    //     $tableData = [];

    //     foreach ($dailyProductStats as $date => $products) {
    //         foreach ($products as $productId => $stats) {
    //             $product = $stats['product'];

    //             $tableData[] = [
    //                 'Date' => $date,
    //                 'Product' => $product->name,
    //                 'Category' => $product->category->title ?? 'Unknown Category',
    //                 'Total' => $stats['quantity'],
    //                 'Profit' => number_format($stats['profit'], 2),
    //             ];
    //         }
    //     }

    //     return response()->json($tableData);
    // }
}
