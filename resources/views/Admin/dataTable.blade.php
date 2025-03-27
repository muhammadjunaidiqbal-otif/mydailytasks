
<!doctype html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-no-customizer"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>DataTables - Tables | Vuexy - Bootstrap Admin Template</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->

    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" />

    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <!-- Form Validation -->
    <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->

    @include('Template.loadercss')
    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>

  </head>

  <body>
    <div id="loader-overlay">
      <div class="loader"></div>
    </div>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        @include('Template.menu')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          @include('Template.navbar')
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- DataTable with Buttons -->
              <div class="card">
                <div class="card-datatable table-responsive pt-0">
                     <div class=" d-flex">
                <button id="deleteRows" style="display:none; background:red; color:white; padding:5px;">Delete Selected</button>
                </div>
                  <table class="datatables-basic table" id="myTable">
                    <thead>
                      <tr>
                        
                        <th></th>
                        <th><input type="checkbox" id="select-all" title="Click To Select All Rows"></th>
                        <th></th>
                        <th></th> 
                        <th>Name</th>
                        {{-- <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Updated_At</th> --}}
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                  </table>

                </div>
              </div>
              
              <!-- Modal to Add record -->
              <div class="offcanvas offcanvas-end" id="add-new-record">
                <div class="offcanvas-header border-bottom">
                  <h5 class="offcanvas-title" id="exampleModalLabel">New Record</h5>
                  <button
                    type="button"
                    class="btn-close text-reset"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
                </div>
                <div class="offcanvas-body flex-grow-1">
                  <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
                    <div class="col-sm-12">
                      <label class="form-label" for="basicFullname">Full Name</label>
                      <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i class="ti ti-user"></i></span>
                        <input
                          type="text"
                          id="basicFullname"
                          class="form-control dt-name"
                          name="basicFullname"
                          placeholder="John Doe"
                          aria-label="John Doe"
                          aria-describedby="basicFullname2" />
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <label class="form-label" for="email">Email</label>
                      <div class="input-group input-group-merge">
                        <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                        <input
                          type="email"
                          id="email"
                          name="email"
                          class="form-control dt-email"
                          placeholder="example@email.com"
                          aria-label="example@email.com"
                          aria-describedby="basicEmail2" />
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <label class="form-label" for="basicPassword">Password</label>
                      <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-mail"></i></span>
                        <input
                          type="password"
                          id="basicPassword"
                          name="basicPassword"
                          class="form-control dt-password"
                          placeholder="*********************"
                          aria-label="********************" />
                      </div>
                      <div class="form-text">Password Must Contain A Capital , A Small And A Numeric Letter </div>
                    </div>
            
                    
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-primary data-submit me-sm-4 me-1">Submit</button>
                      <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- Modal to Edit record -->
              <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editUserModalLabel">Edit Partner</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form id="editUserForm">
                        
                        <input type="hidden" id="editUserId">
                        
                        <div class="mb-3">
                          <label for="editUserName" class="form-label">Name</label>
                          <input type="text" class="form-control" id="editUserName" required>
                        </div>
              
                        <div class="mb-3">
                          <label for="editUserEmail" class="form-label">Email</label>
                          <input type="email" class="form-control" id="editUserEmail" required>
                        </div>
              
                        <div class="mb-3">
                          <label for="editUserRole" class="form-label">Role</label>
                          <select class="form-control" id="editUserRole">
                            <option value="1">Admin</option>
                            <option value="2">Partner</option>
                            <option value="3">Customer</option>
                          </select>
                        </div>
              
                        <button type="submit" class="btn btn-primary">Update</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
             
              <!--/ DataTable with Buttons -->
                <hr class="my-12" />
              
            </div>
            <!-- / Content -->

            <!-- Footer -->
            @include('Template.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    @include('Template.script')

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <!-- Flat Picker -->
    <script src="../../assets/vendor/libs/moment/moment.js"></script>
    <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <!-- Form Validation -->
    <script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
    
    <!-- Page JS -->
    <script>
        var usersDataUrl = "{{ route('users.data') }}";
        var deleteUserUrl = "{{ route('user.delete',':id') }}";
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var editUserUrl = "{{ route('partners.show', ':id') }}";
        var submitEditForm = "{{ route('user.update', ':id') }}";
        var selectDeleteUrl = "{{route('delete-selected')}}";
        var createRecordUrl = "{{route('create-record')}}";
        
        var isAuthenticated = @json(Auth::check());
        var userName = @json(Auth::user()->name ?? '');
  </script>

    <script src="../../assets/js/tables-datatables-basic.js"></script>
  </body>
</html>
