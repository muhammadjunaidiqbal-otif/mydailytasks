@extends('Layouts.users-layout')
@section('title')
    Shop
@endsection
@section('Plugin-CSS')
    <link rel="stylesheet" href="user-assets/css/plugins/jquery.countdown.css">
@endsection
@section('Main-CSS')
    <link rel="stylesheet" href="user-assets/css/style.css">
    <link rel="stylesheet" href="user-assets/css/skins/skin-demo-7.css">
    <link rel="stylesheet" href="user-assets/css/demos/demo-7.css">
    <style>
    
    </style>
@endsection
@section('content')
<main class="main">
    <div class="page-content">
        <div class="container-fluid">
            <div class="toolbox">
                <div class="toolbox-left">
                    <a href="#" class="sidebar-toggler"><i class="icon-bars"></i>Filters</a>
                </div><!-- End .toolbox-left -->

                {{-- <div class="toolbox-center">
                    <div class="toolbox-info">
                        Showing <span>12 of 56</span> Products
                    </div><!-- End .toolbox-info -->
                </div><!-- End .toolbox-center --> --}}

                {{-- <div class="toolbox-right">
                    <div class="toolbox-sort">
                        <label for="sortby">Sort by:</label>
                        <div class="select-custom">
                            <select name="sortby" id="sortby" class="form-control">
                                <option value="popularity" selected="selected">Most Popular</option>
                                <option value="rating">Most Rated</option>
                                <option value="date">Date</option>
                            </select>
                        </div>
                    </div><!-- End .toolbox-sort -->
                </div><!-- End .toolbox-right --> --}}
            </div><!-- End .toolbox -->

            <div class="products">
                <div class="row">
                    @foreach ($products as $product )                        
                    <div class="col-6 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                        <div class="product">
                            <figure class="product-media">
                                <span class="product-label label-new">{{ !empty($product) && $product->in_stock == '1' 
                                    ? 'In Stock' 
                                    : 'Out Of Stock' }}</span>
                                <a href="">
                                    <img src="{{ !empty($product->image) && $product->image !== 'No File Uploaded' 
                                                ? asset('storage/' . $product->image) 
                                                : asset('user-assets/images/products/product-4.jpg') }}" 
                                                alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                </div><!-- End .product-action -->

                                <div class="product-action action-icon-top">
                                    <form action="{{ route('add-to-cart') }}" method="POST" class="add-to-cart-form">
                                        @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <a href="#" class="btn-product btn-cart add-to-cart-btn"><span>add to cart</span></a>
                                    </form>
                                    <a href="popup/quickView.html" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="">{{$product->category->title}}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="">{{$product->name}}</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    ${{$product->price}}
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 0%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 0 Reviews )</span>
                                </div><!-- End .rating-container -->

                                {{-- <div class="product-nav product-nav-dots">
                                    <a href="#" style="background: #cc9966;"><span class="sr-only">Color name</span></a>
                                    <a href="#" class="active" style="background: #ebebeb;"><span class="sr-only">Color name</span></a>
                                </div><!-- End .product-nav --> --}}
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                    @endforeach
                </div><!-- End .row -->

                <div class="load-more-container text-center">
                    <a href="#" class="btn btn-outline-darker btn-load-more">More Products <i class="icon-refresh"></i></a>
                </div><!-- End .load-more-container -->
            </div><!-- End .products -->

            <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
            <aside class="sidebar-shop sidebar-filter">
                <div class="sidebar-filter-wrapper">
                    <div class="widget widget-clean">
                        <label><i class="icon-close"></i>Filters</label>
                        <a href="#" class="sidebar-filter-clear">Clean All</a>
                    </div><!-- End .widget -->
                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                Category
                            </a>
                        </h3><!-- End .widget-title -->

                        {{-- <div class="collapse show" id="widget-1">
                            <div class="widget-body">
                                <div class="filter-items filter-items-count">
                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-1">
                                            <label class="custom-control-label" for="cat-1">Dresses</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">3</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-2">
                                            <label class="custom-control-label" for="cat-2">T-shirts</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">0</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-3">
                                            <label class="custom-control-label" for="cat-3">Bags</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">4</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-4">
                                            <label class="custom-control-label" for="cat-4">Jackets</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">2</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-5">
                                            <label class="custom-control-label" for="cat-5">Shoes</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">2</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-6">
                                            <label class="custom-control-label" for="cat-6">Jumpers</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">1</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-7">
                                            <label class="custom-control-label" for="cat-7">Jeans</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">1</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-8">
                                            <label class="custom-control-label" for="cat-8">Sportwear</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">0</span>
                                    </div><!-- End .filter-item -->
                                </div><!-- End .filter-items -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse --> --}}
                    </div><!-- End .widget -->

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
                                Size
                            </a>
                        </h3><!-- End .widget-title -->

                        {{-- <div class="collapse show" id="widget-2">
                            <div class="widget-body">
                                <div class="filter-items">
                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="size-1">
                                            <label class="custom-control-label" for="size-1">XS</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="size-2">
                                            <label class="custom-control-label" for="size-2">S</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" checked id="size-3">
                                            <label class="custom-control-label" for="size-3">M</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" checked id="size-4">
                                            <label class="custom-control-label" for="size-4">L</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="size-5">
                                            <label class="custom-control-label" for="size-5">XL</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="size-6">
                                            <label class="custom-control-label" for="size-6">XXL</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->
                                </div><!-- End .filter-items -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse --> --}}
                    </div><!-- End .widget -->

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
                                Colour
                            </a>
                        </h3><!-- End .widget-title -->

                        {{-- <div class="collapse show" id="widget-3">
                            <div class="widget-body">
                                <div class="filter-colors">
                                    <a href="#" style="background: #b87145;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #f0c04a;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #333333;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" class="selected" style="background: #cc3333;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #3399cc;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #669933;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #f2719c;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #ebebeb;"><span class="sr-only">Color Name</span></a>
                                </div><!-- End .filter-colors -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse --> --}}
                    </div><!-- End .widget -->

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                Brand
                            </a>
                        </h3><!-- End .widget-title -->

                        {{-- <div class="collapse show" id="widget-4">
                            <div class="widget-body">
                                <div class="filter-items">
                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-1">
                                            <label class="custom-control-label" for="brand-1">Next</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-2">
                                            <label class="custom-control-label" for="brand-2">River Island</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-3">
                                            <label class="custom-control-label" for="brand-3">Geox</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-4">
                                            <label class="custom-control-label" for="brand-4">New Balance</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-5">
                                            <label class="custom-control-label" for="brand-5">UGG</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-6">
                                            <label class="custom-control-label" for="brand-6">F&F</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-7">
                                            <label class="custom-control-label" for="brand-7">Nike</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                </div><!-- End .filter-items -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse --> --}}
                    </div><!-- End .widget -->

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                                Price
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-5">
                            <div class="widget-body">
                                <div class="filter-price">
                                    <div class="filter-price-text">
                                        Price Range:
                                        <span id="filter-price-range"></span>
                                    </div><!-- End .filter-price-text -->

                                    <div id="price-slider"></div><!-- End #price-slider -->
                                </div><!-- End .filter-price -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse -->
                    </div><!-- End .widget -->
                </div><!-- End .sidebar-filter-wrapper -->
            </aside><!-- End .sidebar-filter -->
        </div><!-- End .container-fluid -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-to-cart-btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent the default link behavior
                this.closest('form').submit(); // Submit the closest form
            });
        });
    });
</script>
@endsection

