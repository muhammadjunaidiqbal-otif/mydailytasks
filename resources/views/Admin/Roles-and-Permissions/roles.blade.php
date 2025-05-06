@extends('Layouts.dashboard-layout')
@section('title')
    Roles
@endsection
@section('Vendor-CSS')
<link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

<link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />

@endsection
@section('Page-CSS')
<style>
  .card {
  border-radius: 9px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}
.role-actions a {
  text-decoration: none;
  font-size: 0.875rem; /* Smaller font size for actions */
}
.permissions-box {
  background-color: #f8f9fa;
  border-radius: 8px;
  padding: 10px 15px;
  border: 1px solid #e9ecef;
  margin-top: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  /* Optional: slightly increase the min width */
  min-width: 250px;
}

.permissions-title {
  font-size: 0.9rem;
  font-weight: 600;
  color: #495057;
  margin-bottom: 5px;
}

.permissions-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.permission-item {
  font-size: 0.85rem;
  color: #6c757d;
  padding: 2px 0;
  display: flex;
  align-items: center;
  width: 48%;
  white-space: nowrap; /* Don't break text */
  overflow: hidden;
  text-overflow: ellipsis;
}

.permission-item:before {
  content: "✓";
  color: #28a745;
  margin-right: 8px;
  font-weight: bold;
}
.role-actions a:hover {
  text-decoration: underline;
}

</style>
@endsection
@section('content')
     <!-- Content -->

     <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="mb-1">Roles List</h4>

        <p class="mb-6">
          A role provided access to predefined menus and features so that depending on <br />
          assigned role an administrator can have access to what user needs.
        </p>
        <!-- Role cards -->
        <div class="row g-6">
        @foreach ($roles as $role)
          <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <h6 class="fw-normal mb-0 text-body">Total 1 users</h6>
                  <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                    <li
                      data-bs-toggle="tooltip"
                      data-popup="tooltip-custom"
                      data-bs-placement="top"
                      title="Vinnie Mostowy"
                      class="avatar pull-up">
                      <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar" />
                    </li>
                    {{-- <li
                      data-bs-toggle="tooltip"
                      data-popup="tooltip-custom"
                      data-bs-placement="top"
                      title="Allen Rieske"
                      class="avatar pull-up">
                      <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar" />
                    </li>
                    <li
                      data-bs-toggle="tooltip"
                      data-popup="tooltip-custom"
                      data-bs-placement="top"
                      title="Julee Rossignol"
                      class="avatar pull-up">
                      <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar" />
                    </li>
                    <li
                      data-bs-toggle="tooltip"
                      data-popup="tooltip-custom"
                      data-bs-placement="top"
                      title="Kaith D'souza"
                      class="avatar pull-up">
                      <img class="rounded-circle" src="../../assets/img/avatars/3.png" alt="Avatar" />
                    </li> --}}
                  </ul>
                </div>
                <div class="d-flex justify-content-between align-items-end">
                  <div class="role-heading">
                    <h5 class="mb-1">{{$role->name}}</h5>
                    <div class="role-actions">
                    <a
                      href="javascript:;"
                      {{-- data-bs-toggle="modal"
                      data-bs-target="#addRoleModal" --}}
                      class="role-edit-modal d-block mb-1"
                      data-name="{{$role->name}}" 
                      data-id="{{$role->id}}"
                      aria-label="Edit {{ $role->name }}"
                      ><span>Edit Role</span></a
                    >
                    <a href="javascript:void(0);"data-id="{{ $role->id }}">Delete</a>
                  </div>
                  
                  <div class="permissions-box">
                    <h6 class="permissions-title mb-1">Permissions</h6>
                    <ul class="permissions-list d-flex flex-wrap" style="gap: 0.5rem;">
                      @foreach($role->permissions as $permission)
                        <li class="permission-item text-truncate" style="width: calc(50% - 0.25rem); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $permission->name }}">
                          {{ $permission->name }}
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
                  <a href="javascript:void(0);"><i class="ti ti-copy ti-md text-heading"></i></a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
        <div class="col-xl-4 col-lg-6 col-md-6">
          <div class="card">
            <div class="row g-0 align-items-center">
              <div class="col-sm-5">
                <div class="d-flex align-items-end justify-content-center mt-sm-0 mt-4">
                  <img
                    src="../../assets/img/illustrations/add-new-roles.png"
                    class="img-fluid mt-sm-4 mt-md-0"
                    alt="add-new-roles"
                    width="83" />
                </div>
              </div>
              <div class="col-sm-7">
                <div class="card-body text-sm-end text-center ps-sm-0">
                  <button
                    data-bs-target="#addRoleModal"
                    data-bs-toggle="modal"
                    class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">
                    Add New Role
                  </button>
                  <p class="mb-0">
                    Add new role, <br />
                    if it doesn't exist.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
          {{-- <div class="col-12">
            <h4 class="mt-6 mb-1">Total users with their roles</h4>
            <p class="mb-0">Find all of your company’s administrator accounts and their associate roles.</p>
          </div>
          <div class="col-12">
            <!-- Role Table -->
            <div class="card">
              <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                      <th>User</th>
                      <th>Role</th>
                      <th>Plan</th>
                      <th>Billing</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!--/ Role Table -->
          </div> --}}
        </div>
        <!--/ Role cards -->

        <!-- Add Role Modal -->
        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                  <h4 class="role-title mb-2">Add New Role</h4>
                  <p>Set role permissions</p>
                </div>
                <!-- Add role form -->
                <form id="addRoleForm" class="row g-6" onsubmit="return false">
                  <div>
                    <input type="hidden" name="modalRoleID" id="modalRoleId">
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="modalRoleName">Role Name</label>
                    <input
                      type="text"
                      id="modalRoleName"
                      name="modalRoleName"
                      class="form-control"
                      placeholder="Enter a role name"
                      tabindex="-1" />
                  </div>
                  <div class="col-12">
                    <h5 class="mb-6">Role Permissions</h5>
                    <!-- Permission table -->
                    <div class="table-responsive">
                      <table class="table table-flush-spacing">
                        <tbody>
                          <tr>
                            <td class="text-nowrap fw-medium text-heading">
                              Administrator Access
                              <i
                                class="ti ti-info-circle"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Allows a full access to the system"></i>
                            </td>
                            <td>
                              <div class="d-flex justify-content-end">
                                <div class="form-check mb-0">
                                  <input class="form-check-input" type="checkbox" id="selectAll" />
                                  <label class="form-check-label" for="selectAll"> Select </label>
                                </div>
                              </div>
                            </td>
                          </tr>
                          @foreach ($permissions as $permission )

                          <tr>
                            <td class="text-nowrap fw-medium text-heading">{{$permission->name}}</td>
                            <td>
                              <div class="d-flex justify-content-end">
                                <div class="form-check mb-0">
                                  <input class="form-check-input" type="checkbox" id="permission[{{$permission->name}}]" name="permission[{{$permission->name}}]" value="{{$permission->name}}" />
                                  <label class="form-check-label" for="permission[{{$permission->name}}]"> Select </label>
                                </div>
                              </div>
                            </td>
                          </tr>
                                                        
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    <!-- Permission table -->
                  </div>
                  <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary me-3 submitBtn" id="submitBtn">Submit</button>
                    <button
                      type="reset"
                      class="btn btn-label-secondary"
                      data-bs-dismiss="modal"
                      aria-label="Close">
                      Cancel
                    </button>
                  </div>
                </form>
                <!--/ Add role form -->
              </div>
            </div>
          </div>
        </div>
        <!--/ Add Role Modal -->

        <!-- / Add Role Modal -->
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
<script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>
<script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>
@endsection
@section('Page-JS')
<script src="../../assets/js/app-access-roles.js"></script>
<script src="../../assets/js/modal-add-role.js"></script>
<script>
    var rolesStoreURL = "{{route('roles-store')}}";
    var rolesEditURL = "{{route('roles-edit',':id')}}";
    var rolesUpdateURL = "{{ route('roles-update', ':id') }}";
    var rolesDeleteURL = "{{ route('roles-destroy', ':id') }}";
</script>
@endsection