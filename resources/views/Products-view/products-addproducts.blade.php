@extends('Layouts.dashboard-layout')
@section('title')
   {{isset($products)?"Update Product" : "Add Product"}}
@endsection
@section('Vendor-CSS')
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/tagify/tagify.css" />
@endsection
@section('Page-CSS')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<style>
    /* Loader Overlay */
    #loader-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex; /* Initially visible */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
  
        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
  
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        #toast-container {
        z-index: 99999 !important;
        }
    </style>
@endsection
<div id="loader-overlay">
  <div class="loader"></div>
</div>
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="app-ecommerce">
          <!-- Add Product -->
          <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
              <h4 class="mb-1">{{isset($products)?"Update Product":"Add A New Product"}}</h4>
              <p class="mb-0">Orders placed across your store</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
              <div class="d-flex gap-4">
                <button class="btn btn-label-secondary ">Discard</button>
                {{-- <button class="btn btn-label-primary">Save draft</button> --}}
              </div>
              <button type="button" class="btn btn-primary {{isset($products)? 'updateBtn':'publishBtn'}} ">{{isset($products)?"Update":"Publish"}}</button>
            </div>
          </div>

          <div class="row">
            <!-- First column-->
            <div class="col-12 col-lg-8">
              <!-- Product Information -->
              <div class="card mb-6">
                <div class="card-header">
                  <h5 class="card-tile mb-0">Product information</h5>
                </div>
                <div class="card-body">
                  <input type="hidden"value="{{isset($products)?$products->id:''}}" id="ecommerce-product-id">
                  <div class="mb-6">
                    <label class="form-label" for="ecommerce-product-name">Name</label>
                    <input
                      type="text"
                      class="form-control"
                      id="ecommerce-product-name"
                      placeholder="Product title"
                      name="name"
                      aria-label="Product title"
                      value="{{isset($products)?$products->name:''}}" />
                  </div>
                  <div class="row mb-6">
                    <div class="col">
                      <label class="form-label" for="ecommerce-product-sku">SKU</label>
                      <input
                        type="number"
                        class="form-control"
                        id="ecommerce-product-sku"
                        placeholder="SKU"
                        name="sku"
                        aria-label="Product SKU"
                        value="{{isset($products)?$products->sku:''}}" />
                    </div>
                    <div class="col">
                      <label class="form-label" for="ecommerce-product-barcode">Barcode</label>
                      <input
                        type="text"
                        class="form-control"
                        id="ecommerce-product-barcode"
                        placeholder="0123-4567"
                        name="barcode"
                        aria-label="Product barcode"
                        value="{{isset($products)?$products->barcode:''}}" />
                    </div>
                  </div>
                  <!-- Description -->
                  <div>
                    <label class="mb-1">Description (Optional)</label>
                    <div class="form-control p-0">
                      <div class="comment-toolbar border-0 border-bottom">
                        <div class="d-flex justify-content-start">
                          <span class="ql-formats me-0">
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                            <button class="ql-list" value="ordered"></button>
                            <button class="ql-list" value="bullet"></button>
                            <button class="ql-link"></button>
                            <button class="ql-image"></button>
                          </span>
                        </div>
                      </div>
                      <div class="comment-editor border-0 pb-6" id="ecommerce-category-description">  {!! isset($products) && $products->description ? $products->description : '' !!}</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Product Information -->
              <!-- Media -->
              <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0 card-title">Product Image</h5>
                  <a href="javascript:void(0);" class="fw-medium">Add media from URL</a>
                </div>
                <div class="card-body">
                  <form action="/upload" class="dropzone needsclick p-0" id="dropzone-basic">
                    @if(!empty($products) && $products->image && $products->image !== 'No File Uploaded')
                    <div class="mb-4 position-relative" id="existing-image-wrapper">
                      <img src="{{ asset('storage/' . $products->image) }}" 
                           alt="Product Image" 
                           class="img-fluid rounded" 
                           style="max-height: 200px;">
                      <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" id="remove-image">
                        Remove
                      </button>
                      <input type="hidden" name="remove_image" id="remove_image" value="0">
                    </div>
                  @endif
                    <div class="dz-message needsclick">
                      <p class="h4 needsclick pt-3 mb-2">Drag and drop your image here</p>
                      <p class="h6 text-muted d-block fw-normal mb-2">or</p>
                      <span class="note needsclick btn btn-sm btn-label-primary" id="btnBrowse"
                        >Browse image</span
                      >
                    </div>
                    <div class="fallback">
                      <input id="ecommerce-category-image" name="image" type="file" />
                    </div>
                  </form>
                </div>
              </div>
              <!-- /Media -->
              <!-- Variants -->
              {{-- <div class="card mb-6">
                <div class="card-header">
                  <h5 class="card-title mb-0">Variants</h5>
                </div>
                <div class="card-body">
                  <form class="form-repeater">
                    <div data-repeater-list="group-a">
                      <div data-repeater-item>
                        <div class="row">
                          <div class="mb-6 col-4">
                            <label class="form-label" for="form-repeater-1-1">Options</label>
                            <select id="form-repeater-1-1" class="select2 form-select" data-placeholder="Size">
                              <option value="">Size</option>
                              <option value="size">Size</option>
                              <option value="color">Color</option>
                              <option value="weight">Weight</option>
                              <option value="smell">Smell</option>
                            </select>
                          </div>

                          <div class="mb-6 col-8">
                            <label class="form-label invisible" for="form-repeater-1-2">Not visible</label>
                            <input
                              type="number"
                              id="form-repeater-1-2"
                              class="form-control"
                              placeholder="Enter size" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <button class="btn btn-primary" data-repeater-create>
                        <i class="ti ti-plus ti-xs me-2"></i>
                        Add another option
                      </button>
                    </div>
                  </form>
                </div>
              </div> --}}
              <!-- /Variants -->
              <!-- Inventory -->
              {{-- <div class="card mb-6">
                <div class="card-header">
                  <h5 class="card-title mb-0">Inventory</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <!-- Navigation -->
                    <div class="col-12 col-md-4 col-xl-5 col-xxl-4 mx-auto card-separator">
                      <div class="d-flex justify-content-between flex-column mb-4 mb-md-0 pe-md-4">
                        <div class="nav-align-left">
                          <ul class="nav nav-pills flex-column w-100">
                            <li class="nav-item">
                              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#restock">
                                <i class="ti ti-box ti-sm me-1_5"></i>
                                <span class="align-middle">Restock</span>
                              </button>
                            </li>
                            <li class="nav-item">
                              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping">
                                <i class="ti ti-car ti-sm me-1_5"></i>
                                <span class="align-middle">Shipping</span>
                              </button>
                            </li>
                            <li class="nav-item">
                              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#global-delivery">
                                <i class="ti ti-world ti-sm me-1_5"></i>
                                <span class="align-middle">Global Delivery</span>
                              </button>
                            </li>
                            <li class="nav-item">
                              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#attributes">
                                <i class="ti ti-link ti-sm me-1_5"></i>
                                <span class="align-middle">Attributes</span>
                              </button>
                            </li>
                            <li class="nav-item">
                              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#advanced">
                                <i class="ti ti-lock ti-sm me-1_5"></i>
                                <span class="align-middle">Advanced</span>
                              </button>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <!-- /Navigation -->
                    <!-- Options -->
                    <div class="col-12 col-md-8 col-xl-7 col-xxl-8 pt-6 pt-md-0">
                      <div class="tab-content p-0 ps-md-4">
                        <!-- Restock Tab -->
                        <div class="tab-pane fade show active" id="restock" role="tabpanel">
                          <h6 class="text-body">Options</h6>
                          <label class="form-label" for="ecommerce-product-stock">Add to Stock</label>
                          <div class="row mb-4 g-4 pe-md-4">
                            <div class="col-12 col-sm-9">
                              <input
                                type="number"
                                class="form-control"
                                id="ecommerce-product-stock"
                                placeholder="Quantity"
                                name="quantity"
                                aria-label="Quantity" />
                            </div>
                            <div class="col-12 col-sm-3">
                              <button class="btn btn-primary">Confirm</button>
                            </div>
                          </div>
                          <div>
                            <h6 class="mb-2 fw-normal">Product in stock now: 54</h6>
                            <h6 class="mb-2 fw-normal">Product in transit: 390</h6>
                            <h6 class="mb-2 fw-normal">Last time restocked: 24th June, 2023</h6>
                            <h6 class="mb-0 fw-normal">Total stock over lifetime: 2430</h6>
                          </div>
                        </div>
                        <!-- Shipping Tab -->
                        <div class="tab-pane fade" id="shipping" role="tabpanel">
                          <h6 class="mb-3 text-body">Shipping Type</h6>
                          <div>
                            <div class="form-check mb-4">
                              <input class="form-check-input" type="radio" name="shippingType" id="seller" />
                              <label class="form-check-label" for="seller">
                                <span class="mb-1 h6">Fulfilled by Seller</span><br />
                                <small
                                  >You'll be responsible for product delivery.<br />
                                  Any damage or delay during shipping may cost you a Damage fee.</small
                                >
                              </label>
                            </div>
                            <div class="form-check mb-6">
                              <input
                                class="form-check-input"
                                type="radio"
                                name="shippingType"
                                id="companyName"
                                checked />
                              <label class="form-check-label" for="companyName">
                                <span class="mb-1 h6"
                                  >Fulfilled by Company name &nbsp;<span
                                    class="badge rounded-2 badge-warning bg-label-warning fs-tiny py-1"
                                    >RECOMMENDED</span
                                  ></span
                                ><br />
                                <small
                                  >Your product, Our responsibility.<br />
                                  For a measly fee, we will handle the delivery process for you.</small
                                >
                              </label>
                            </div>
                            <p class="mb-0">
                              See our <a href="javascript:void(0);">Delivery terms and conditions</a> for details
                            </p>
                          </div>
                        </div>
                        <!-- Global Delivery Tab -->
                        <div class="tab-pane fade" id="global-delivery" role="tabpanel">
                          <h6 class="mb-3 text-body">Global Delivery</h6>
                          <!-- Worldwide delivery -->
                          <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="globalDel" id="worldwide" />
                            <label class="form-check-label" for="worldwide">
                              <span class="mb-1 h6">Worldwide delivery</span><br />
                              <small
                                >Only available with Shipping method:
                                <a href="javascript:void(0);">Fulfilled by Company name</a></small
                              >
                            </label>
                          </div>
                          <!-- Global delivery -->
                          <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="globalDel" checked />
                            <label class="form-check-label w-75 pe-12" for="country-selected">
                              <span class="mb-2 h6">Selected Countries</span>
                              <input
                                type="text"
                                class="form-control"
                                placeholder="Type Country name"
                                id="country-selected" />
                            </label>
                          </div>
                          <!-- Local delivery -->
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="globalDel" id="local" />
                            <label class="form-check-label" for="local">
                              <span class="mb-1 h6">Local delivery</span><br />
                              <small
                                >Deliver to your country of residence :
                                <a href="javascript:void(0);">Change profile address</a></small
                              >
                            </label>
                          </div>
                        </div>
                        <!-- Attributes Tab -->
                        <div class="tab-pane fade" id="attributes" role="tabpanel">
                          <h6 class="mb-2 text-body">Attributes</h6>
                          <div>
                            <!-- Fragile Product -->
                            <div class="form-check mb-4">
                              <input class="form-check-input" type="checkbox" value="fragile" id="fragile" />
                              <label class="form-check-label" for="fragile">
                                <span class="fw-medium">Fragile Product</span>
                              </label>
                            </div>
                            <!-- Biodegradable -->
                            <div class="form-check mb-4">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                value="biodegradable"
                                id="biodegradable" />
                              <label class="form-check-label" for="biodegradable">
                                <span class="fw-medium">Biodegradable</span>
                              </label>
                            </div>
                            <!-- Frozen Product -->
                            <div class="form-check mb-4">
                              <input class="form-check-input" type="checkbox" value="frozen" checked />
                              <label class="form-check-label w-75 pe-12" for="frozen">
                                <span class="mb-1 h6">Frozen Product</span>
                                <input
                                  type="number"
                                  class="form-control"
                                  placeholder="Max. allowed Temperature"
                                  id="frozen" />
                              </label>
                            </div>
                            <!-- Exp Date -->
                            <div class="form-check mb-6">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                value="expDate"
                                id="expDate"
                                checked />
                              <label class="form-check-label w-75 pe-12" for="date-input">
                                <span class="mb-1 h6">Expiry Date of Product</span>
                                <input type="date" class="product-date form-control" id="date-input" />
                              </label>
                            </div>
                          </div>
                        </div>
                        <!-- /Attributes Tab -->
                        <!-- Advanced Tab -->
                        <div class="tab-pane fade" id="advanced" role="tabpanel">
                          <h6 class="mb-3 text-body">Advanced</h6>
                          <div class="row">
                            <!-- Product Id Type -->
                            <div class="col">
                              <label class="form-label" for="product-id">
                                <span class="mb-1 h6">Product ID Type</span>
                              </label>
                              <select id="product-id" class="select2 form-select" data-placeholder="ISBN">
                                <option value="">ISBN</option>
                                <option value="ISBN">ISBN</option>
                                <option value="UPC">UPC</option>
                                <option value="EAN">EAN</option>
                                <option value="JAN">JAN</option>
                              </select>
                            </div>
                            <!-- Product Id -->
                            <div class="col">
                              <label class="form-label" for="product-id-1">
                                <span class="mb-1 h6">Product ID</span>
                              </label>
                              <input
                                type="number"
                                id="product-id-1"
                                class="form-control"
                                placeholder="ISBN Number" />
                            </div>
                          </div>
                        </div>
                        <!-- /Advanced Tab -->
                      </div>
                    </div>
                    <!-- /Options-->
                  </div>
                </div>
              </div> --}}
              <!-- /Inventory -->
            </div>
            <!-- /Second column -->

            <!-- Second column -->
            <div class="col-12 col-lg-4">
               <!-- Organize Card -->
               <div class="card mb-6">
                <div class="card-header">
                  <h5 class="card-title mb-0">Organize</h5>
                </div>
                <div class="card-body">
                  <!-- Vendor -->
                  {{-- <div class="mb-6 col ecommerce-select2-dropdown">
                    <label class="form-label mb-1" for="vendor"> Vendor </label>
                    <select id="vendor" class="select2 form-select" data-placeholder="Select Vendor">
                      <option value="">Select Vendor</option>
                      <option value="men-clothing">Men's Clothing</option>
                      <option value="women-clothing">Women's-clothing</option>
                      <option value="kid-clothing">Kid's-clothing</option>
                    </select>
                  </div> --}}
                  <!-- Category -->
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-6 col ecommerce-select2-dropdown">
                      <label class="form-label mb-1" for="category-org">
                        <span>Category</span>
                      </label>
                      <select id="category-org" class="select2 form-select" data-placeholder="Select Category" name="category_id">
                        <option value="{{isset($products)?$products->category_id:''}}">{{isset($products)?$products->category->title : "Select A Category"}}</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                      </select>
                    </div>
                    {{-- <a href="javascript:void(0);" class="fw-medium btn btn-icon btn-label-primary ms-4"
                      ><i class="ti ti-plus ti-md"></i
                    ></a> --}}
                  </div>
                  <!-- Collection -->
                  {{-- <div class="mb-6 col ecommerce-select2-dropdown">
                    <label class="form-label mb-1" for="collection">Collection </label>
                    <select id="collection" class="select2 form-select" data-placeholder="Collection">
                      <option value="">Collection</option>
                      <option value="men-clothing">Men's Clothing</option>
                      <option value="women-clothing">Women's-clothing</option>
                      <option value="kid-clothing">Kid's-clothing</option>
                    </select>
                  </div> --}}
                  <!-- Status -->
                  <div class="mb-6 col ecommerce-select2-dropdown">
                    <label class="form-label mb-1" for="status-org">Status </label>
                    <select id="status-org" class="select2 form-select" data-placeholder="Published">
                      <option value="{{isset($products)?$products->status:'Publis'}}">{{isset($products)?$products->status:'Publis'}}</option>
                      <option value="Publish">Publish</option>
                      <option value="Scheduled">Scheduled</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                  <!-- Tags -->
                  {{-- <div>
                    <label for="ecommerce-product-tags" class="form-label mb-1">Tags</label>
                    <input
                      id="ecommerce-product-tags"
                      class="form-control"
                      name="ecommerce-product-tags"
                      value="Normal,Standard,Premium"
                      aria-label="Product Tags" />
                  </div> --}}
                </div>
              </div>
              <!-- /Organize Card -->
              <!-- Pricing Card -->
              <div class="card mb-6">
                <div class="card-header">
                  <h5 class="card-title mb-0">Pricing</h5>
                </div>
                <div class="card-body">
                  <!-- Base Price -->
                  <div class="mb-6">
                    <label class="form-label" for="ecommerce-product-price">Base Price</label>
                    <input
                      type="number" 
                      class="form-control"
                      id="ecommerce-product-price"
                      @if(isset($products))
                      value="{{$products->base_price}}"
                      @endif
                      placeholder="Enter Basic Price"
                      aria-label="Product price"
                      name="base_price"
                       />
                  </div>
                  <!-- Discounted Price -->
                  <div class="mb-6">
                    <label class="form-label" for="ecommerce-product-discount-price">Discounted Price</label>
                    <input
                      type="number"
                      class="form-control"
                      id="ecommerce-product-discount-price"
                      @if(isset($products))
                      value="{{$products->discounted_price}}"
                      @endif
                      placeholder="Discounted Price"
                      aria-label="Product discounted price"
                      name="discounted_price"
                      value="{{isset($products)?$products->discounted_price:''}} />
                  </div>
                  <!-- Charge tax check box -->
                  <div class="form-check ms-2 mt-2 mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="price-charge-tax" @if(isset($products) && $products->charge_tax) checked @endif />
                    <label class="switch-label" for="price-charge-tax"> Charge tax on this product </label>
                  </div>
                  <!-- Instock switch -->
                  <div class="d-flex justify-content-between align-items-center border-top pt-2">
                    <span class="mb-0">In stock</span>
                    <div class="w-25 d-flex justify-content-end">
                      <div class="form-check form-switch me-n3">
                        <input type="checkbox" class="form-check-input" id="product-instock" @if(isset($products) && $products->in_stock) checked @endif />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Pricing Card -->
            </div>
            <!-- /Second column -->
          </div>
        </div>
      </div>
      <!-- / Content -->
@endsection
@section('Build-JS')
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>
@endsection
@section('Vendor-JS')
    <script src="../../assets/vendor/libs/quill/katex.js"></script>
    <script src="../../assets/vendor/libs/quill/quill.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/dropzone/dropzone.js"></script>
    <script src="../../assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="../../assets/vendor/libs/tagify/tagify.js"></script>
@endsection
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

<!-- jQuery (Toastr depends on it) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    @if (session('status'))
        toastr.success("{{ session('status') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
@section('Page-JS')
    <script src="../../assets/js/app-ecommerce-product-add.js"></script>
    <script>
      var storeProductURL = "{{route('store-products')}}";
      var updateProductURL = "{{route('update-product',':id')}}";
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const removeBtn = document.getElementById('remove-image');
        if (removeBtn) {
          removeBtn.addEventListener('click', function () {
            document.getElementById('existing-image-wrapper').remove();
            document.getElementById('remove_image').value = 1;
          });
        }
      });
    </script>
@endsection
