@extends('Layouts.users-layout')
@section('title')
    Home
@endsection
@section('Plugin-CSS')
    <link rel="stylesheet" href="user-assets/css/plugins/jquery.countdown.css">
@endsection
@section('Main-CSS')
    <link rel="stylesheet" href="user-assets/css/style.css">
    <link rel="stylesheet" href="user-assets/css/skins/skin-demo-7.css">
    <link rel="stylesheet" href="user-assets/css/demos/demo-7.css">
@endsection
@section('content')
<main class="main">
    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $cart = session('cart', []); @endphp
                                {{-- @php dd($cart); @endphp --}}
                                @foreach($cart as $product)
                                <tr>
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="#">
                                                    <img src="{{ !empty($product['image']) && $product['image'] !== 'No File Uploaded' 
                                                ? asset('storage/' . $product['image']) 
                                                : asset('user-assets/images/products/product-4.jpg') }}" alt="Product image">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a href="#">{{$product['name']}}</a>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">{{$product['price']}}</td>
                                    <td class="quantity-col">
                                        <div class="cart-product-quantity">
                                            <input type="spinner" class="form-control quantity-input" value="{{$product['quantity']}}" min="1" max="10" step="1" data-decimals="0" data-id="{{ $product['id'] }}" required>
                                        </div><!-- End .cart-product-quantity -->
                                    </td>
                                    <td class="total-col">{{$product['price']*$product['quantity']}}.00</td>
                                    <td class="remove-col">
                                        <form action="{{ route('remove-from-cart') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product['id']}}">
                                            <button type="submit" class="btn-remove"><i class="icon-close"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table><!-- End .table table-wishlist -->

                        {{-- <div class="cart-bottom">
                            <div class="cart-discount">
                                <form action="#">
                                    <div class="input-group">
                                        <input type="text" class="form-control" required placeholder="coupon code">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
                                        </div><!-- .End .input-group-append -->
                                    </div><!-- End .input-group -->
                                </form>
                            </div><!-- End .cart-discount -->

                            <a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
                        </div><!-- End .cart-bottom --> --}}
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->
                            
                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td class="sub-total"></td>
                                    </tr><!-- End .summary-subtotal -->
                                    <tr class="summary-total">
                                        <td >Total:</td>
                                        <td class="total"></td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <a id="checkoutButton" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                        </div><!-- End .summary -->

                        <a href="{{route('users-shop-page')}}" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@endsection
@section('Plugin-JS')
    <script src="user-assets/js/bootstrap-input-spinner.js"></script>
    <script>
        var updateCartInputURL = "{{ route('update-cart-quantity') }}";
        var checkOutURL = "{{ route('users-checkout-page') }}";
    </script>
@endsection 