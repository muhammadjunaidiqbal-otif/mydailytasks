@extends('Layouts.layout')
@section('content')
@section('card-title')
Register
@endsection
@section('card-body')

    <form action="{{route('newuser.register')}}" method="POST">
    @csrf
        <div class="mb-3">
        <label for="name" class="form-label">Name : </label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter Your Name" required>
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>    
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter Your Email" required>
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password" required>
            @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Re-Enter Your Password" required>
            @error('password_confirmation')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
        <hr>
        <div class="mb-3 mt-3">

            <label for="country" class="form-label">Address : </label>
            <div class="row">
            <div class="col-md-4">
                <select id="country" name="country_id" class="form-select">
                    <option value="">Select Country</option>
                     @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                     @endforeach 
                </select>
            </div>
            <div class="col-md-4">
                <select id="state" name="state_id" class="form-select">
                    <option value="">Select State</option>
                   
                </select>
            </div>
            <div class="col-md-4">
                <select id="city" name="city_id" class="form-select">
                    <option value="">Select City</option>
                    
                </select>
            </div>
        </div>
        </div>
        <button class="btn btn-primary w-100">Register</button>
</form>
@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="text-center mt-3">
        <a href="{{ route('login.page') }}" class="text-decoration-none">Already have an account? Login</a>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#country').on('change', function(){
            var countryId = $(this).val();

            if(countryId){
                $.ajax({
                    url: '/get-states/' + countryId, 
                    type: 'GET',
                    success: function(data){
                        $('#state').empty().append('<option value="">Select State</option>');
                        $('#city').empty().append('<option value="">Select City</option>'); 

                        $.each(data, function(key, value) {
                            $('#state').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    },
                    error: function() {
                        alert('Unable to fetch states. Please try again.');
                    }
                });
            } else {
                $('#state').empty().append('<option value="">Select State</option>');
                $('#city').empty().append('<option value="">Select City</option>');
            }
        });

        $('#state').on('change',function(){
            stateId = $(this).val();
            if(stateId){
                $.ajax({
                    url : '/get-cities/' + stateId ,
                    type : 'GET' , 
                    success : function(data){
                      
                        $('#city').empty().append('<option value="">Select City</option>'); 
                        $.each(data,function(key , value){
                            $('#city').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    },
                    error: function() {
                        alert('Unable to fetch cities. Please try again.');
                    }
                });
            }else{
                $('#state').empty().append('<option value="">Select State</option>');
                $('#city').empty().append('<option value="">Select City</option>');
            }
        });

    });

   

</script>




@endsection


@endsection