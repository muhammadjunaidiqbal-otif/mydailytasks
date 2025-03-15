@extends('Layouts.layout')
@section('content')
@section('card-title')
    Partner-Index
@endsection
@section('card-body')
    {{--$users--}}
    <table class="table table-stiped table-bordered">
        <thead>
            <tr>
               {{-- <th>ID</th> --}}
                <th>Name</th>
                <th>Email</th>
                <th class="text-center">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                {{-- <td>{{ $user->id }}</td> --}}
                <td>{{ $user->name }}</td>
                <td>{{$user->email}}</td>
                 <td>
                    <div class="text-center">
                        <a href="{{route('partners.edit', $user->id)}}" class="btn btn-warning btn-sm ">Edit</a>
                        <button type="button" class="btn btn-info btn-sm view-details" data-bs-toggle="modal" data-bs-target="#userDetailsModal" data-id="{{ $user->id }}" >Details</button>
                        <form  action="{{ route('partners.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm ">Delete</button>
                        </form>
                    </div>
                </td> 
            </tr>
            @endforeach
        </tbody>
    
    </table>
    <div class="mb-3  mt-3">
        <button type="button" class="btn btn-primary w-100" onclick="window.location.href='{{ route('partners.create') }}'"><b>Add New Partner</b></button>
    </div>
    
@endsection 

    
      
    <!-- User Details Modal -->
    <div class="modal fade" id="userDetailsModal" tabindex="-1" role="dialog" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailsModalLabel">User Details</h5>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong><h4><span id="modalUserId"></span></h4></p>
                    <p><strong>Name:</strong> <h4><span id="modalUserName"></span></h4></p>
                    <p><strong>Email:</strong> <h4><span id="modalUserEmail"></span></h4></p>
                    <p><strong>Role:</strong> <h4><span id="modalUserRole"></span></h4></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
   
    $(document).ready(function(){
        $('.view-details').on('click',function(){
            var userId = $(this).data('id');
            $.ajax({
                url: "{{ route('partners.show','') }}/" + userId, 
                type: "GET",
                success: function(response) {
                    $('#modalUserId').text(response.id);
                    $('#modalUserName').text(response.name);
                    $('#modalUserEmail').text(response.email);
                    $('#modalUserRole').text(response.role.name); 

                    $('#userDetailsModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        });
    });
</script>

@endsection