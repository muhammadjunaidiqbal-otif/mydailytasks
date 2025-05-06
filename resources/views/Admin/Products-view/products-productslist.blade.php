@extends('Layouts.dashboard-layout')
@section('title')
    Products List
@endsection
@section('Vendor-CSS')
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
@endsection
@section('Page-CSS')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<style>
  </style>
@endsection
@section('content')
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
  <!-- Product List Widget -->
  <div class="card mb-6">
    <div class="card-widget-separator-wrapper">
      <div class="card-body card-widget-separator">
        <div class="row gy-4 gy-sm-1">
          <div class="col-sm-6 col-lg-3">
            <div
              class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
              <div>
                <p class="mb-1">In-store Sales</p>
                <h4 class="mb-1">$5,345.43</h4>
                <p class="mb-0">
                  <span class="me-2">5k orders</span><span class="badge bg-label-success">+5.7%</span>
                </p>
              </div>
              <span class="avatar me-sm-6">
                <span class="avatar-initial rounded"
                  ><i class="ti-28px ti ti-smart-home text-heading"></i
                ></span>
              </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none me-6" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <div
              class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
              <div>
                <p class="mb-1">Website Sales</p>
                <h4 class="mb-1">$674,347.12</h4>
                <p class="mb-0">
                  <span class="me-2">21k orders</span><span class="badge bg-label-success">+12.4%</span>
                </p>
              </div>
              <span class="avatar p-2 me-lg-6">
                <span class="avatar-initial rounded"
                  ><i class="ti-28px ti ti-device-laptop text-heading"></i
                ></span>
              </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <div
              class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
              <div>
                <p class="mb-1">Discount</p>
                <h4 class="mb-1">$14,235.12</h4>
                <p class="mb-0">6k orders</p>
              </div>
              <span class="avatar p-2 me-sm-6">
                <span class="avatar-initial rounded"><i class="ti-28px ti ti-gift text-heading"></i></span>
              </span>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="mb-1">Affiliate</p>
                <h4 class="mb-1">$8,345.23</h4>
                <p class="mb-0">
                  <span class="me-2">150 orders</span><span class="badge bg-label-danger">-3.5%</span>
                </p>
              </div>
              <span class="avatar p-2">
                <span class="avatar-initial rounded"
                  ><i class="ti-28px ti ti-wallet text-heading"></i
                ></span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Product List Table -->
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">Filter</h5>
      <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0">
        <div class="col-md-4 product_status"></div>
        <div class="col-md-4 product_category"></div>
        <div class="col-md-4 product_stock"></div>
      </div>
      
    </div>
    <div class="card-datatable table-responsive">
      <div class=" d-flex">
        <button id="deleteRows" style="display:none; background:red; color:white; padding:5px;">Delete Selected</button>
        </div>
      <table class="datatables-products table">
        <thead class="border-top">
          <tr>
            <th></th>
            <th><input type="checkbox" id="select-all" title="Click To Select All Rows"></th>
            <th>product</th>
            <th>category</th>
            <th>stock</th>
            <th>Sale Till</th>
            <th>description</th>
            <th>price</th>
            <th>discounted </th>
            <th>status</th>
            <th>actions</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
{{-- Edit Modal --}}

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
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
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
     // Show loader for 1.5 seconds, then show content
     window.onload = function () {
          setTimeout(function () {
            
              document.getElementById("loader-overlay").style.display = "none";
              if(isAuthenticated){
                toastr.success("Page Loaded Successfully!", "Welcome "+ userName);
              }else{
                toastr.success("Page Loaded Successfully!", "Welcome ");
              }
               
              
          
            }, 1500); // 1.5 seconds
      };

</script>
@section('Page-JS')
    <script src="../../assets/js/app-ecommerce-product-list.js"></script>
    <script>
      var addProductURL = "{{route('add-products')}}";
      var productsListURL = "{{route('list-products')}}";
      var csrfToken = $('meta[name="csrf-token"]').attr('content')
      var deleteCategoryURL = "{{route('delete-product',':id')}}";
      var editProductURL = "{{route('edit-product',':id')}}";
      var selectDeleteUrl = "{{route('delete-selected-products')}}";
      var updateProductSaleEndURL = "{{route('add-products-saleEnd')}}";
    </script>
@endsection
