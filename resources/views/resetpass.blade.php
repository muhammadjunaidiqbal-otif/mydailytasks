@extends('Layouts.layout')
@section('content')
@section('card-title')
Reset
@endsection
@section('card-body')
<form action="{{route('sumbit.resetpass')}}" method="POST">
    @csrf
    
    
        <div class="mb-3">
            <input type="hidden" name="token" value="{{$token}}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{$email}}" readonly>
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="text" class="form-control" name="password" id="password" required>
            @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
        <label for="confirm-pass" class="form-label">Confirm Password : </label>
        <input type="text" name="confirm-pass" class="form-control" required>
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>    
        <button class="btn btn-primary w-100">Save</button>
</form>
@endsection
@endsection