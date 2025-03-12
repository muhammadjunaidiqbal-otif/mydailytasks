@extends('Layouts.layout')
@section('content')
@section('card-title')
Password Reset
@endsection
@section('card-body')
    <form action="{{route('send.email')}}" method="get">
        
        <div class="mb-3">
            <input type="text" name="email" class="form-control" value="{{$email}}" readonly>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send Email</button>    

    </form>
@endsection
@endsection
