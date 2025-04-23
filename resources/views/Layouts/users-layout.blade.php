<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="user-assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="user-assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="user-assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="user-assets/images/icons/site.html">
    <link rel="mask-icon" href="user-assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="user-assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="user-assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="user-assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="user-assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @yield('Fav-Icon')

    <!-- For Font Awesome 5+ -->    
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="user-assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="user-assets/css/main.min.css">

    @yield('Plugin-CSS')

    <!-- Main CSS File -->
    <link rel="stylesheet" href="user-assets/css/style.css">
    <link rel="stylesheet" href="user-assets/css/plugins/nouislider/nouislider.css">
    @yield('Main-CSS')
    <style>
        .dropdown-cart-action a.btn {
    padding: 0.6rem 1rem;
    font-size: 14px;
    border-radius: 5px;
}

.dropdown-cart-action {
    margin-top: 1rem;
    gap: 0.5rem;
}

@media (max-width: 400px) {
    .dropdown-cart-action a.btn {
        font-size: 12px;
        padding: 0.5rem;
    }
}
.color-changing-spinner {
    border: 5px solid #f3f3f3;
    border-top: 5px solid red;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite, colorchange 2s linear infinite;
    margin: 100px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes colorchange {
    0%   { border-top-color: red; }
    25%  { border-top-color: blue; }
    50%  { border-top-color: green; }
    75%  { border-top-color: orange; }
    100% { border-top-color: purple; }
}
    </style>
</head>
<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <div class="header-dropdown">
                            <a href="#">Usd</a>
                            <div class="header-menu">
                                <ul>
                                    <li><a href="#">Eur</a></li>
                                    <li><a href="#">Usd</a></li>
                                </ul>
                            </div><!-- End Currency .header-menu -->
                        </div><!-- End .header-dropdown -->

                        <div class="header-dropdown">
                            <a href="#">Eng</a>
                            <div class="header-menu">
                                <ul>
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">French</a></li>
                                    <li><a href="#">Spanish</a></li>
                                </ul>
                            </div><!-- End .header-menu -->
                        </div><!-- End Language.header-dropdown -->
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <ul class="top-menu">
                            <li>
                                <a href="#">Links</a>
                                <ul>
                                    <li><a href="tel:#"><i class="icon-phone"></i>Call: +0123 456 789</a></li>
                                    <li><a href=""><i class="icon-heart-o"></i>Wishlist <span>(3)</span></a></li>
                                    <li><a href="{{route('login-page')}}"><i class="icon-user"></i>Login</a></li>
                                </ul>
                            </li>
                        </ul><!-- End .top-menu -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-top -->

            <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>

                        <a href="{{route('users-home-page')}}" class="logo">
                            <img src="../../user-assets/images/logo.png" alt="Molla Logo" width="105" height="25">
                        </a>

                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="megamenu-container {{ request()->routeIs('users-home-page') ? 'active' : '' }}">
                                    <a href="{{route('users-home-page')}}" class="">Home</a>
                                </li>
                                <li class="{{ request()->routeIs('users-shop-page') ? 'active' : '' }}">
                                    <a href="{{route('users-shop-page')}}" class="">Shop</a>
                                </li>
                                <li class="{{ request()->routeIs('users-about-page') ? 'active' : '' }}">
                                    <a href="{{route('users-about-page')}}" class="">About Us</a>
                                </li>
                                <li class="{{ request()->routeIs('users-contact-page') ? 'active' : '' }}">
                                    <a href="{{route('users-contact-page')}}" class="">Contact Us</a>
                                </li>
                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <div class="header-search">
                            <a href="#" class="search-toggle" role="button" title="Search"><i class="icon-search"></i></a>
                            <form action="#" method="get">
                                <div class="header-search-wrapper">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search in..." required>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                        {{-- <div class="dropdown compare-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Compare Products" aria-label="Compare Products">
                                <i class="icon-random"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="compare-products">
                                    <li class="compare-product">
                                        <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                        <h4 class="compare-product-title"><a href="product.html">Blue Night Dress</a></h4>
                                    </li>
                                    <li class="compare-product">
                                        <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                        <h4 class="compare-product-title"><a href="product.html">White Long Skirt</a></h4>
                                    </li>
                                </ul>

                                <div class="compare-actions">
                                    <a href="#" class="action-link">Clear All</a>
                                    <a href="#" class="btn btn-outline-primary-2"><span>Compare</span><i class="icon-long-arrow-right"></i></a>
                                </div>
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .compare-dropdown --> --}}
                        <div class="dropdown cart-dropdown ">
                            <a href="" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-shopping-cart {{ request()->routeIs('users-cart-page') ? 'disabled' : '' }}"></i>
                                {{-- <span class="cart-count"></span> --}}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">
                                    @php $cart = session('cart', []); @endphp
                                    @if(count($cart)>0)
                                    @foreach($cart as $product)
                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="product.html">{{$product['name']}}</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">{{$product['quantity']}}</span>
                                                x {{$product['price']}}
                                            </span>
                                        </div><!-- End .product-cart-details -->

                                        <figure class="product-image-container">
                                            <a href="" class="product-image">
                                                <img src="{{ !empty($product['image']) && $product['image'] !== 'No File Uploaded' 
                                                ? asset('storage/' . $product['image']) 
                                                : asset('user-assets/images/products/product-4.jpg') }}" alt="product">
                                            </a>
                                        </figure>
                                        <form action="{{ route('remove-from-cart') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product['id']}}">
                                            <button type="submit" class="btn-remove"><i class="icon-close"></i></button>
                                        </form>
                                    </div><!-- End .product -->
                                    @endforeach
                                    @else
                                    <h5>No Items Selected</h5>
                                    @endif
                                </div><!-- End .cart-product -->

                                {{-- <div class="dropdown-cart-total">
                                    <span>Total</span>

                                    <span class="cart-total-price"></span>
                                </div><!-- End .dropdown-cart-total --> --}}

                                <div class="dropdown-cart-action d-flex gap-2">
                                    <a href="{{route('users-cart-page')}}" class="btn btn-sm btn-primary flex-fill text-center">View Cart</a>
                                    <a href="{{ route('users-checkout-page') }}" class="btn btn-sm btn-outline-primary-2 flex-fill d-flex justify-content-center align-items-center">
                                        <span>Checkout</span>
                                        <i class="icon-long-arrow-right ml-2"></i>
                                    </a>
                                </div><!-- End .dropdown-cart-total -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->
                        <!-- End .cart-dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->
        </header><!-- End .header -->
        
        @sectionMissing('content')
            <div class="loader-wrapper" style="display:flex;justify-content:center;align-items:center;height:200px;">
                <div class="spinner-border text-primary color-changing-spinner" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        @else
            @yield('content')
        @endif
        
        <footer class="footer">
        	<div class="footer-middle">
	            <div class="container">
	            	<div class="row">
	            		<div class="col-sm-6 col-lg-3">
	            			<div class="widget widget-about">
	            				<img src="user-assets/images/logo.png" class="footer-logo" alt="Footer Logo" width="105" height="25">
	            				<p>Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. </p>

	            				<div class="social-icons">
                                    <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
                                </div><!-- End .social-icons -->
	            			</div><!-- End .widget about-widget -->
	            		</div><!-- End .col-sm-6 col-lg-3 -->

	            		<div class="col-sm-6 col-lg-3">
	            			<div class="widget">
	            				<h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->

	            				<ul class="widget-list">
	            					<li><a href="about.html">About Molla</a></li>
	            					<li><a href="#">How to shop on Molla</a></li>
	            					<li><a href="#">FAQ</a></li>
	            					<li><a href="contact.html">Contact us</a></li>
	            					<li><a href="login.html">Log in</a></li>
	            				</ul><!-- End .widget-list -->
	            			</div><!-- End .widget -->
	            		</div><!-- End .col-sm-6 col-lg-3 -->

	            		<div class="col-sm-6 col-lg-3">
	            			<div class="widget">
	            				<h4 class="widget-title">Customer Service</h4><!-- End .widget-title -->

	            				<ul class="widget-list">
	            					<li><a href="#">Payment Methods</a></li>
	            					<li><a href="#">Money-back guarantee!</a></li>
	            					<li><a href="#">Returns</a></li>
	            					<li><a href="#">Shipping</a></li>
	            					<li><a href="#">Terms and conditions</a></li>
	            					<li><a href="#">Privacy Policy</a></li>
	            				</ul><!-- End .widget-list -->
	            			</div><!-- End .widget -->
	            		</div><!-- End .col-sm-6 col-lg-3 -->

	            		<div class="col-sm-6 col-lg-3">
	            			<div class="widget">
	            				<h4 class="widget-title">My Account</h4><!-- End .widget-title -->

	            				<ul class="widget-list">
	            					<li><a href="#">Sign In</a></li>
	            					<li><a href="{{route('users-cart-page')}}">View Cart</a></li>
	            					<li><a href="#">My Wishlist</a></li>
	            					<li><a href="#">Track My Order</a></li>
	            					<li><a href="#">Help</a></li>
	            				</ul><!-- End .widget-list -->
	            			</div><!-- End .widget -->
	            		</div><!-- End .col-sm-6 col-lg-3 -->
	            	</div><!-- End .row -->
	            </div><!-- End .container -->
	        </div><!-- End .footer-middle -->

	        <div class="footer-bottom">
	        	<div class="container">
	        		<p class="footer-copyright">Copyright © 2019 Molla Store. All Rights Reserved.</p><!-- End .footer-copyright -->
	        		<figure class="footer-payments">
	        			<img src="user-assets/images/payments.png" alt="Payment methods" width="272" height="20">
	        		</figure><!-- End .footer-payments -->
	        	</div><!-- End .container -->
	        </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
        <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
 <!-- Mobile Menu -->
 <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

 <div class="mobile-menu-container">
     <div class="mobile-menu-wrapper">
         <span class="mobile-menu-close"><i class="icon-close"></i></span>

         <form action="#" method="get" class="mobile-search">
             <label for="mobile-search" class="sr-only">Search</label>
             <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
             <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
         </form>
         
         <nav class="mobile-nav">
             <ul class="mobile-menu">
                 <li class="active">
                     <a href="index.html">Home</a>
                     <ul>
                     </ul>
                 </li>
                 <li>
                     <a href="category.html">Shop</a>
                     <ul>        
                     </ul>
                 </li>
                 <li>
                     <a href="product.html" class="sf-with-ul">About</a>
                     <ul>   
                     </ul>
                 </li>
                 <li>
                     <a href="#">Pages</a>
                     <ul>
                         <li>
                             <a href="about.html">About</a>
                             <ul>
                             </ul>
                         </li>
                         <li>
                             <a href="contact.html">Contact</a>
                             <ul>
                             </ul>
                         </li>
                         <li><a href="login.html">Login</a></li>
                         <li><a href="faq.html">FAQs</a></li>
                         <li><a href="404.html">Error 404</a></li>
                         <li><a href="coming-soon.html">Coming Soon</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="blog.html">Blog</a>
                     <ul>
                         <li></li>
                     </ul>
                 </li>
                 <li>
                     <a href="elements-list.html">Elements</a>
                     <ul>
                        <li></li>                        
                     </ul>
                 </li>
             </ul>
         </nav><!-- End .mobile-nav -->
         <div class="social-icons">
            <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
        </div><!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->
    <!-- Plugins JS File -->
    <script src="user-assets/js/jquery.min.js"></script>
    <script src="user-assets/js/bootstrap.bundle.min.js"></script>
    <script src="user-assets/js/jquery.hoverIntent.min.js"></script>
    <script src="user-assets/js/jquery.waypoints.min.js"></script>
    <script src="user-assets/js/superfish.min.js"></script>
    <script src="user-assets/js/owl.carousel.min.js"></script>
    <script src="user-assets/js/bootstrap-input-spinner.js"></script>
    <script src="user-assets/js/jquery.magnific-popup.min.js"></script>
    <script src="user-assets/js/wNumb.js"></script>
    <script src="user-assets/js/nouislider.min.js"></script>
    @yield('Plugin-JS')
    <!-- Main JS File -->    
    <script src="user-assets/js/main.js"></script>
    @yield('Main-JS')
</body>
</html>