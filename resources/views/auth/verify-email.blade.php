@extends('Layouts.layout')
@section('content')
@section('card-title')
Email Verification
@endsection
@section('card-body')

    <h2>Verify Your Email Address</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
@php
    $user = Auth::user();
@endphp
    <p>Before proceeding, please check your email for a verification link.</p>
    <p>If you did not receive the email, click below to request another.</p>
    <div class="text-center d-flex justify-content-center mt-3">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>
    <form action="{{(route('verified.mail'))}}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{$user->email}}">
        <button class="btn btn-danger mx-3">Yes ! I'm Verified</button>
    </form>
    </div>
@endsection 
@endsection