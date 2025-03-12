@extends('Layouts.layout')
@section('content')
@section('card-title')
Reset Password
@endsection
@section('card-body')

    <form action="{{ route('pass.reset') }}" method="POST">
    @csrf    
    <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="example@email.com" required>
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            @if (session('status'))
                <div class="text-danger mt-1">
                {{ session('status') }}
                </div>
            @endif        
        </div>
        <button type="submit" class="btn btn-primary w-100">Verify Email</button>
    </form>        
@endsection
@endsection
