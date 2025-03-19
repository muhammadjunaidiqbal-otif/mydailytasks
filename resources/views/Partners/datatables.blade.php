<!DOCTYPE html>
<html>
<head>
    <title>Laravel DataTables Without Yajra</title>
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
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
        "ajax": {
            "url": "{{ route('users.data') }}",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "email" },
            { 
                "data": "role",
                "render": function(data, type, row) {
                    return data ? data.name : 'No Role'; 
                }
            }
        ]
    });
});
</script>

</body>
</html>