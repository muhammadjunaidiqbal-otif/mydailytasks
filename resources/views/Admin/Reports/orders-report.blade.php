@extends('Layouts.dashboard-layout')
@section('title')
   Orders Report
@endsection
@section('Vendor-CSS')
<link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

<link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/quill/typography.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/quill/katex.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/quill/editor.css" />
@endsection
@section('Page-CSS')
<link rel="stylesheet" href="../../assets/vendor/css/pages/app-ecommerce.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
     <!-- Category List Table -->
     <div class="card m-4">
        <div class="card-datatable table-responsive">
          <div class=" d-flex">
            <select name="customer" id="customer" class="form-control m-3" style="width: 200px;">
              <option value="">Select Customer</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
              @endforeach
            </select>
            <select name="category" id="category" class="form-control m-3" style="width: 200px;">
              <option value="">Select Category</option>
              @foreach ($categories as $category)
              <option value="{{ $category->id }}">{{ $category->title }}</option>
              @endforeach
            </select>
            <select name="product" id="product" class="form-control m-3" style="width: 200px;">
              <option value="">Select Product</option>
              @foreach ($products_items as $product)
              <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
              @endforeach
            </select>
            <input type="text" id="daterange" class="form-control  m-3" style="width: 203px;" placeholder="Select date range" readonly />
            <button id="viewBtn" class="btn btn-primary m-3">View</button>
          </div>
          <table class="datatables-category-list table border-top" id="myTable">
            <thead>
              <tr>
                <th>Date</th>
                <th >Product</th>
                <th>Category</th>
                <th>Total</th>
                <th>Profit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tableData as $product)
              <tr>
                  <td>{{ $product['Date'] }}</td>
                  <td>{{ $product['Product'] }}</td>
                  <td>{{ $product['Category'] }}</td>
                  <td>{{ $product['Total'] }}</td>
                  <td>{{ $product['Profit'] }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
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
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>
<script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>
<script src="../../assets/vendor/libs/quill/katex.js"></script>
<script src="../../assets/vendor/libs/quill/quill.js"></script>
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
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function () {
      let dataTable = $('#myTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        responsive: true,
        lengthMenu: [4, 10, 15]
    });
      $('#daterange').daterangepicker({
        opens: 'left',
        startDate: moment(),
        endDate: moment(),
        locale: {
            format: 'YYYY-MM-DD'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')]
        }
    });
  });
  $('#viewBtn').on('click', function () {
        const dateRange = $('#daterange').val();
        const userId = $('#customer').val();
        const categoryId = $('#category').val();
        const productId = $('#product').val();
        console.log("userId"+userId)
        
        let startDate = null;
        let endDate = null;

        if (dateRange) {
            const dates = dateRange.split(' - ');
            startDate = dates[0];
            endDate = dates[1];
        }
        let url = "{{ route('orders-report-page') }}?";
      
        if (startDate) {
            url += `start=${startDate}&`;
        }
      
        if (endDate) {
            url += `end=${endDate}&`;
        }
      
        if (userId) {
            url += `user_id=${userId}&`;
        }
      
        if (categoryId) {
            url += `category_id=${categoryId}&`;
        }
      
        if (productId) {
            url += `product_id=${productId}&`;
        }

        url = url.replace(/&$/, '');
        window.location.href = url;
});

  </script>
@endsection