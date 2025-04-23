@extends('Layouts.users-layout')

@section('title', 'Order Success')
@section('content')
<div class="container">
    <h2 class="mb-4">Pending Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total</th>
                <th>Payment Status</th>
                <th>Cart Items</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                    <td>
                        <ul>
                            @foreach(json_decode($order->cart, true) as $item)
                                <li>{{ $item['name'] }} (x{{ $item['quantity'] }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('checkout', ['order_id' => $order->id]) }}" class="btn btn-primary btn-sm">Checkout</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No pending orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection