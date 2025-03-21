<!DOCTYPE html>
<html>
<head>
    <title>Partners DataTable</title>
@include('Datatables.dt-script')
</head>
<body>

<div class="container">
    <h2>Users List</h2>
    <table id="usersTable" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#usersTable').DataTable({
        "processing": true,
        "serverSide": false,
        "lengthMenu": false,
        "paginate":false,
        "searching":false,
        "ajax": {
            "url": "{{ route('users.data') }}",
            "dataSrc": "info"
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "email" },
            { 
                "data": "role",
                "render": function(data, type, row) {
                    return data ? data.name : 'user'; 
                }
            } 
        ]
    });
});
</script>

</body>
</html>