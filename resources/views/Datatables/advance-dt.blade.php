<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced DataTable</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Toastr CSS (for notifications) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Custom CSS (if needed) -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
    @include('Datatables.dt-script')
    
</head>
<body>

    
    <div class="container-xxl flex-grow-1 container-p-y">
        
        
        <div class="card">
          <div class="card-datatable table-responsive pt-0">
            <div class="divider">
                <span class="divider-text"><h1><strong>User DataTable</strong></h1></span>
            </div>
            
        <div class="mb-3">
            <button id="deleteRows" style="display:none; background:red; color:white; padding:5px;">Delete Selected</button>
        </div>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all"></th> 
                <th>ID</th>
                <th>Name</th>
                {{-- <th>Email</th>
                <th>Roles</th> --}}
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <div id="loader" class="loader-overlay">
                <div class="text-primary" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>
        </tbody>
    </table>
</div>
</div>
</div>

{{-- Edit Modal --}}
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
                <option value="admin">Admin</option>
                <option value="editor">Partner</option>
                <option value="user">Customer</option>
              </select>
            </div>
  
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
 

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap JS (Popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
         function confirmAction() {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
        });
    }
        var selectedRows = {};
        $(document).ready(function() {
            //Datatable
           var dt_basic =  $('#myTable').DataTable({
                "processing": true,
                "serverSide": false,
                "searching": true,
                "lengthMenu": [10, 20, 50],
                 "dom": 'Blfrtip', 
                 buttons: [
                            'csv', 
                            'print',
                            'excel'
                        ],
                "ajax":{
                    "url": "{{ route('users.data') }}",
                    "dataSrc": "info",
                    "beforeSend": function () {
                        $('#loader').fadeIn();  // Show loader before request
                        },
                    "complete": function () {
                        $('#loader').fadeOut(); // Hide loader after data is fetched
                    }
                },
                "columns": [
                    {
               
                    "data": null,
                    "render": function(data, type, row) {
                        return '<input type="checkbox" class="select-checkbox" data-id="' + row.id + '">';
                    },
                    "orderable": true 
                    },
                                { "data": "id",visible:false },
                                { "data": "name" },
                                //{ "data": "email" },
                                // { 
                                //      "data": "role",//"visible":false,
                                //     "render": function(data, type, row) {
                                //         return data ? data.name : 'user'; 
                                //     }
                                // },
                                {
                                    "render": function(data , type , full) {
                                    return `
                                        <button class="btn-edit" data-id="${full.id}" >Edit</button>
                                        <button class="btn-delete" data-id="${full.id}" data-name = "${full.name}">Delete</button>
                                    `;
                                    },
                                "orderable":false
                                } 
                                ],
                            order: [[2, 'asc']],
                            language: {
                                processing: "<span class='text-primary'>Loading...</span>"
                            },
                            initComplete: function (settings, json) {
                             $('.card-header').after('<hr class="my-0">');
                             }
               
            });
            // Select All Checkboxes
            $('#select-all').on('change', function () {
    var isChecked = this.checked;

    // Select all checkboxes, including those not in the current page
    $('.select-checkbox').prop('checked', isChecked);

    $('#myTable').DataTable().rows().every(function () {
        var row = this.node();
        var rowId = $(row).find('.select-checkbox').data('id');

        if (isChecked) {
            selectedRows[rowId] = true;
        } else {
            delete selectedRows[rowId];
        }
    });

    updateDeleteButtonVisibility();
});

$('#myTable tbody').on('change', '.select-checkbox', function () {
        var rowId = $(this).data('id');
        if (this.checked) {
            selectedRows[rowId] = true;
        } else {
            delete selectedRows[rowId];
            $('#select-all').prop('checked', false);
        }
        if ($('.select-checkbox:checked').length === $('.select-checkbox').length) {
        $('#select-all').prop('checked', true);
    }

        updateDeleteButtonVisibility();
    });
    dt_basic.on('draw', function () {
        $('.select-checkbox').each(function () {
            var rowId = $(this).data('id');
            $(this).prop('checked', selectedRows[rowId] === true);
        });

        $('#select-all').prop('checked', Object.keys(selectedRows).length === dt_basic.rows().count());

        updateDeleteButtonVisibility();
    });
    function updateDeleteButtonVisibility() {
        var selectedCount = Object.keys(selectedRows).length;
        $('#deleteRows').toggle(selectedCount > 0);
    }
    $(document).on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        console.log(name);
        
        Swal.fire({
            title: "Are you sure?",
            text: "You Want To Delete : " + name,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('user.delete', ':id') }}".replace(':id', id),
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response.msg,
                            icon: "success",
                            confirmButtonText: "OK"
                        });
                        $('#myTable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: "Error deleting user.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                });
            }
        });
    });

            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');

                $.ajax({
                url: "{{ route('partners.show', ':id') }}".replace(':id', id), 
                type: "GET",
                success: function(response) {
                    $('#editUserId').val(response.id);
                    $('#editUserName').val(response.name);
                    $('#editUserEmail').val(response.email);
                    
                
                    // Open Modal - Bootstrap 5 Syntax
                    var myModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                    myModal.show();
                    },
                    error: function(xhr) {
                    alert("Error fetching user data.");
                    }
                });
            });
            //submit Edit Form Modal
            $(document).on('submit', '#editUserForm', function(e) {
                e.preventDefault(); 
                        
                var id = $('#editUserId').val();
                var name = $('#editUserName').val();
                var email = $('#editUserEmail').val();
                var role = $('#editUserRole').val();
                        
                $.ajax({
                    url: "{{ route('user.update', ':id') }}".replace(':id', id), 
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", 
                        id: id,
                        name: name,
                        email: email,
                        role: role
                    },
                    success: function(response) {
                        alert(response.success);
                        $('#editUserModal').modal('hide'); 
                        $('#myTable').DataTable().ajax.reload(); 
                    },
                    error: function(xhr) {
                        alert("Error updating user.");
                    }
                });
        });
        //delete selected rows
        $('#deleteRows').on('click', function () {
        var selectedIds = Object.keys(selectedRows);
        if (selectedIds.length === 0) {
            alert("No users selected.");
            return;
        }

        if (!confirm("Are you sure you want to delete selected users?")) return;

        $.ajax({
            url: "{{route('delete-selected')}}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ids: selectedIds
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message); 
                } else {
                    alert("Error: " + response.message); 
                }
                selectedRows = {}; 
                table.ajax.reload();
                updateDeleteButtonVisibility();
            },
            error: function () {
                console.error(xhr.responseText);
                alert("Error: " + xhr.responseText);
            }
        });
    });

    });
    </script>

</body>
</html>