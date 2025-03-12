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
        <button class="btn btn-primary w-100">Register</button>
</form>
    <div class="text-center mt-3">
        <a href="{{ route('login.page') }}" class="text-decoration-none">Already have an account? Login</a>
    </div>
    @endsection
@endsection