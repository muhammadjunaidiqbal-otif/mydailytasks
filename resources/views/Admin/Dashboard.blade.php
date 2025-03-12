@extends('Layouts.layout')
@section('content')
@section('card-title')
Dashboard
@endsection
@section('card-body')
@php
   $user = Auth::user() 
@endphp

{{--$user->email--}}
    <div class="text-center d-flex justify-content-center mt-3">
        <div class="mb-3">
            <a href="{{route('logout')}}"class="btn btn-danger mx-3">Logout</a>
        </div>
        {{-- <form action="{{(route('mail.send'))}}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{$user->email}}">
            <button class="btn btn-danger mx-3">Verify Email</button>
        </form> --}}
    </div>
             @if(isset($info['success']))
                <div class="text-danger text-center mt-3 mb-3" id="success-message">
                {{ $info['success'] }}
                </div>
            @endif  



            <script>
                setTimeout(function() {
                    var message = document.getElementById("success-message");
                    if (message) {
                        message.style.display = "none";
                    }
                }, 3000); 
            </script>

@endsection 
@endsection