@extends('Layouts.layout')
@section('content')
@section('card-title')
Register

<link rel="stylesheet" href="h
ttps://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
                <select id="state" name="state_id"  class="form-select">
                    <option value="">Select State</option>
                   
                </select>
            </div>
            <div class="col-md-4">
                <select id="city" name="city_id"  class="form-select">
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


@endsection
@endsection
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<!-- Toastr CSS -->
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

    @if ($errors->any())  
        @foreach ($errors->all() as $error)
            console.log("{{ $error }}");
            setTimeout(() => {
                toastr.error('{{ $error }}');
            }, 3000);
        @endforeach
    @endif

    @if (session('success'))
        toastr.success('{{ session('success') }}');
    @endif
</script>