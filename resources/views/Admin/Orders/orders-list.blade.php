@extends('Layouts.dashboard-layout')
@section('title')
    Orders List
@endsection
@section('Vendor-CSS')
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
    
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
@endsection
@section('Page-CSS')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
  .dt-buttons .dt-datepicker-wrapper {
  padding: 0 !important;
  border: none !important;
}
.dt-buttons input.form-control {
  height: 60px;
  font-size: 0.875rem;
}
</style>
@endsection
@section('content')
     <!-- Content -->

     <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Order List Widget -->

        <div class="card mb-6">
          <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
              <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-3">
                  <div
                    class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                    <div>
                      @php
                        $pending_payments = 0 ;
                        foreach ($orders as $order) {
                          if($order->payment_status == "pending"){
                          $pending_payments++;
                          }
                        }
                      @endphp
                      <h4 class="mb-0">{{$pending_payments}}</h4>
                      <p class="mb-0">Pending Payment</p>
                    </div>
                    <span class="avatar me-sm-6">
                      <span class="avatar-initial bg-label-secondary rounded text-heading">
                        <i class="ti-26px ti ti-calendar-stats text-heading"></i>
                      </span>
                    </span>
                  </div>
                  <hr class="d-none d-sm-block d-lg-none me-6" />
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div
                    class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                    <div>
                      @php
                        $completed_orders = 0 ;
                        foreach ($orders as $order) {
                          if($order->payment_status == "paid"){
                          $completed_orders++;
                          }
                        }
                      @endphp
                      <h4 class="mb-0">{{$completed_orders}}</h4>
                      <p class="mb-0">Completed</p>
                    </div>
                    <span class="avatar p-2 me-lg-6">
                      <span class="avatar-initial bg-label-secondary rounded"
                        ><i class="ti-26px ti ti-checks text-heading"></i
                      ></span>
                    </span>
                  </div>
                  <hr class="d-none d-sm-block d-lg-none" />
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div
                    class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                    <div>
                      @php
                        $refunded_orders = 0 ;
                        foreach ($orders as $order) {
                          if($order->payment_status == "refunded"){
                          $refunded_orders++;
                          }
                        }
                      @endphp
                      <h4 class="mb-0">{{$refunded_orders}}</h4>
                      <p class="mb-0">Refunded</p>
                    </div>
                    <span class="avatar p-2 me-sm-6">
                      <span class="avatar-initial bg-label-secondary rounded"
                        ><i class="ti-26px ti ti-wallet text-heading"></i
                      ></span>
                    </span>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      @php
                        $failed_orders = 0 ;
                        foreach ($orders as $order) {
                          if($order->payment_status == "unpaid"){
                          $failed_orders++;
                          }
                        }
                      @endphp
                      <h4 class="mb-0">{{$failed_orders}}</h4>
                      <p class="mb-0">Failed</p>
                    </div>
                    <span class="avatar p-2">
                      <span class="avatar-initial bg-label-secondary rounded"
                        ><i class="ti-26px ti ti-alert-octagon text-heading"></i
                      ></span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order List Table -->
        <div class="card">
          <div class="mb-3">
            <label for="orderDateRange" class="form-label">Filter by Order Date:</label>
            <input type="text" id="orderDateRange" class="form-control text-center" style="width: 280px; display: inline-block;" readonly>
          </div>
          <div class="card-datatable table-responsive">
            <table class="datatables-order table border-top" id="table-info">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th>order</th>
                  <th>date</th>
                  <th>customers</th>
                  <th>payment</th>
                  <th>status</th>
                  <th>method</th>
                  <th>actions</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      <!-- / Content -->
@endsection
@section('Build-JS')
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

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
    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
@endsection
@section('Page-JS')
    <!-- Page JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="../../assets/js/app-ecommerce-order-list.js"></script>
    <script>
        var orderListURL = "{{route('orders-list')}}";
        var orderDetailsURL = "{{route('order-detail',':id')}}";
    </script>
<
@endsection