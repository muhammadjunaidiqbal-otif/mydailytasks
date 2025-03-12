@extends('Layouts.layout') 
@section('content')
@section('card-title')     
Login
@endsection
@section('card-body')

                        
    <form action="{{ route('login.user') }}" method="POST">
    @csrf  
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="example@email.com" required>
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror        
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="**************" required>
            @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
        <label class="d-flex justify-content-center align-items-center mt-3">
    <input type="checkbox" name="remember" class="me-2"> Remember Me
</label>
        <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
    </form>
        <div class="text-center mt-3">
            <a href="{{ route('reset.page') }}" class="text-decoration-none">Forgot Password</a>
        </div>
                       
        <div class="text-center mt-3">
            <a href="{{ route('register.page') }}" class="text-decoration-none">Don't have an account? Register</a>
        </div>
        
            
    @endsection 
@endsection
