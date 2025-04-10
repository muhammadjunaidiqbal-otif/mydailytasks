@extends('Layouts.dashboard-layout')
@section('title')
  Category
@endsection
@section('Vendor-CSS')
<link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

<link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
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
    <div class="app-ecommerce-category">
      <!-- Category List Table -->
      <div class="card">
        <div class="card-datatable table-responsive">
          <div class=" d-flex">
            <button id="deleteRows" style="display:none; background:red; color:white; padding:5px;">Delete Selected</button>
            </div>
          <table class="datatables-category-list table border-top" id="myTable">
            <thead>
              <tr>
                <th>Actions</th>
                <th><input type="checkbox" id="select-all" title="Click To Select All Rows"></th>
                <th></th>
                <th>title</th>
                <th class="text-nowrap text-sm-end">slug &nbsp;</th>
                <th>Image</th>
                <th>Parent ID</th>
                <th>Description</th>
                <th>Status</th>
                {{-- <th class="text-nowrap text-sm-end"></th> --}}
                <th class="text-lg-center">Actions</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <!-- Offcanvas to add new customer -->
      <div
        class="offcanvas offcanvas-end"
        tabindex="-1"
        id="offcanvasEcommerceCategoryList"
        aria-labelledby="offcanvasEcommerceCategoryListLabel">
        <!-- Offcanvas Header -->
        <div class="offcanvas-header py-6">
          <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">Add Category</h5>
          <button
            type="button"
            class="btn-close text-reset"
            data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
        </div>
        <!-- Offcanvas Body -->
        <div class="offcanvas-body border-top">
          <form class="pt-0" id="eCommerceCategoryListForm" onsubmit="return true">
            <!-- Title -->
            <input type="hidden" name="id" id="ecommerce-category-id" >
            <div class="mb-6">
              <label class="form-label" for="ecommerce-category-title">Title</label>
              <input
                type="text"
                class="form-control"
                id="ecommerce-category-title"
                placeholder="Enter category title"
                name="categoryTitle"
                aria-label="category title" />
            </div>
            <!-- Slug -->
            <div class="mb-6">
              <label class="form-label" for="ecommerce-category-slug">Slug</label>
              <input
                type="text"
                id="ecommerce-category-slug"
                class="form-control"
                placeholder="Enter slug"
                aria-label="slug"
                name="slug" />
            </div>
            <!-- Image -->
            <div class="mb-6">
              <label class="form-label" for="ecommerce-category-image">Attachment</label>
              <input class="form-control" type="file" id="ecommerce-category-image" name="attachment" accept="image/png, image/gif, image/jpeg"  />
            </div>
            <!-- Parent category -->
            <div class="mb-6 ecommerce-select2-dropdown">
              <label class="form-label" for="ecommerce-category-parent-category">Parent category</label>
              <select
                id="ecommerce-category-parent-category"
                class="select2 form-select"
                data-placeholder="Select parent category">
                <option value="">Select parent Category</option>
                <option value="Household">Household</option>
                <option value="Management">Management</option>
                <option value="Electronics">Electronics</option>
                <option value="Office">Office</option>
                <option value="Automotive">Automotive</option>
              </select>
            </div>
            <!-- Description -->
            <div class="mb-6">
              <label class="form-label">Description</label>
              <div class="form-control p-0 py-1">
                <div class="comment-editor border-0" id="ecommerce-category-description" style="height: 100px"></div>
                <div class="comment-toolbar border-0 rounded">
                  <div class="d-flex justify-content-end">
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
              </div>
              <!-- 👇 Hidden input that will hold Quill content -->
              <input type="hidden" name="description" id="description">
            </div>
            <!-- Status -->
            <div class="mb-6 ecommerce-select2-dropdown">
              <label class="form-label">Select category status</label>
              <select
                id="ecommerce-category-status"
                class="select2 form-select"
                data-placeholder="Select category status">
                <option value="">Select category status</option>
                <option value="Scheduled">Scheduled</option>
                <option value="Publish">Publish</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
            <!-- Submit and reset -->
            <div class="mb-6">
              <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit data-update">Add</button>
              <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Discard</button>
            </div>
          </form>
        </div>
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
<script src="../../assets/js/app-ecommerce-category-list.js"></script>
<script>
  var usersDataUrl = "{{ route('users.data') }}";
  var categoriesDataURL = "{{route('categories.data')}}"
  var csrfToken = $('meta[name="csrf-token"]').attr('content')
  var categoriesFormSubmit = "{{route('categories-store')}}"
  var editCategoryURL = "{{route('categories-update',':id')}}"
  var submitEditCategoryFormURL = "{{route('category.edit')}}" 
</script>
@endsection
