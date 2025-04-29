@extends('Layouts.users-layout')

@section('title', 'Order Success')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="text-success">🎉 Order Successful!</h1>
        <p class="lead">Thank you for your purchase. Your payment was successful.</p>
    </div>

    <div class="card shadow-lg p-4">
        <h4 class="mb-3 text-center mt-4">Invoice Summary</h4>
        <hr>
        
        @php
            $order = \App\Models\Orders::with('billingAddress')->find(request('order_id'));
            //echo $order;
            $billing = $order->billingAddress;
            //echo $billing;
            $cart = json_decode($order->cart, true);
        @endphp

        <div class="mb-3">
            <strong>Invoice ID:</strong> #{{ $order->id }}<br>
            <strong>Date:</strong> {{ $order->created_at->format('F j, Y') }}
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Billing Information</h5>
                 <p>
                    {{ $billing->first_name }} {{ $billing->last_name }}<br>
                    {{ $billing->address }}<br>
                    {{ $billing->city->name ?? '' }}, {{ $billing->state->name ?? '' }}<br>
                    {{ $billing->country->name ?? '' }} - {{ $billing->postal_code }}<br>
                    Phone: {{ $billing->phone }}<br>
                    Email: {{ $billing->email }}
                </p> 
            </div>
        </div>

        <h5>Order Details</h5>
        <table class="table table-bordered mt-3">
            <thead >
                <strong><tr class="text-center">
                    <th>#</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price ($)</th>
                    <th>Subtotal ($)</th>
                </tr></strong>
            </thead>
            <tbody>
                @php $i = 1; $total = 0; @endphp
                @foreach($cart as $item)
                    @php
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp
                    <tr class="text-center">
                        <td>{{ $i++ }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>${{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mt-3">
            <h4><strong>Total Paid:</strong> ${{ number_format($total, 2) }}</h4>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('users-shop-page') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
    <div class="text-center mt-5">
        <a href="{{ route('orders.pending') }}" class="btn btn-primary">View Pendig Orders</a>
    </div>
</div>
@endsection
