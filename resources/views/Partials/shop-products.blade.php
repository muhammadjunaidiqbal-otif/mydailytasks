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
                        ${{$product->base_price}}
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