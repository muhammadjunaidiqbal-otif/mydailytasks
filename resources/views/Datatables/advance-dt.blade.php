<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced DataTable</title>
    @include('Datatables.dt-script')
    
</head>
<body>

    
    <div class="container-xxl flex-grow-1 container-p-y">
       
        <div class="card">
          <div class="card-datatable table-responsive pt-0">
            <div class="divider">
                <span class="divider-text"><h1><strong>Partners DataTable</strong></h1></span>
            </div>
        <div class="mb-3">
            <button id="deleteRows" style="display:none; background:red; color:white; padding:5px;">Delete Selected</button>
        </div>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all">Select All</th> 
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            
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

<!-- Bootstrap JS (Popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            //Datatable
            $('#myTable').DataTable({
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
                    "dataSrc": "info"
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
                                { "data": "email" },
                                { 
                                     "data": "role",//"visible":false,
                                    "render": function(data, type, row) {
                                        return data ? data.name : 'user'; 
                                    }
                                },
                                { 
                                    "data": "id",
                                    "render": function(data) {
                                    return `
                                        <button class="btn-edit" data-id="${data}">Edit</button>
                                        <button class="btn-delete" data-id="${data}">Delete</button>
                                    `;
                        }
                       
                    } 
                            ]
               
            });
            // checkboxes
            $('#select-all').on('click', function() {
                var rows = $('#myTable').DataTable().rows({ search: 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
                var selectedCount = $('.select-checkbox:checked').length;
                $('#deleteRows').toggle(selectedCount > 0);

            });

            $('#myTable tbody').on('change', 'input[type="checkbox"]', function() {
                var selectedCount = $('.select-checkbox:checked').length;
                $('#deleteRows').toggle(selectedCount > 0);
               
            });
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');

                if (confirm("Are you sure you want to delete User " + id + "?")) {
                    $.ajax({
                        url: "{{ route('user.delete', ':id') }}".replace(':id', id), 
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}" // CSRF token for Laravel
                        },
                        success: function(response) {
                            alert(response.msg); // Show response message
                            $('#myTable').DataTable().ajax.reload(); // Refresh DataTable
                        },
                        error: function(xhr) {
                            alert("Error deleting user.");
                        }
                    });
                }
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
                        $('#editUserModal').modal('hide'); // Hide modal after update
                        $('#myTable').DataTable().ajax.reload(); // Refresh DataTable
                    },
                    error: function(xhr) {
                        alert("Error updating user.");
                    }
                });
        });
        //delete selected rows
        $('#deleteRows').on('click',function(){
            var selectedIds = [];
            $('.select-checkbox:checked').each(function() {
                    selectedIds.push($(this).data('id'));
                });
                if(confirm("AreYou Sure You want to delete These Ids - " + selectedIds)){
                    $.ajax({
                        url : "{{route('delete-selected')}}",
                        type : "POST",
                        data : {ids : selectedIds , _token: "{{ csrf_token()}}"},
                        success : function(data){
                            alert(data.success);
                            $('#myTable').DataTable().ajax.reload(); 
                            $('#deleteRows').hide();
                        },
                        error : function(xhr){
                            alert("Error deleting records.");
                        }
                    });
                }
           
        });


    });
    </script>

</body>
</html>