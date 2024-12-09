@extends('Blogbackend.components.layout')

@section('title', 'My Profile')

@section('content')
@php
    $user = session('user');
@endphp
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<h1>Profile Details</h1>
    <div class="profilecontainer">
       
        <div class="col">
            <div class="box">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}" disabled>
            </div>
            <div class="box">
                <label for="gender">Gender:</label>
                <input type="text" name="gender" id="gender" class="form-control" value="{{$user->gender}}" disabled>
            </div>
            <div class="box">
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" class="form-control" value="{{$user->email}}" disabled>
            </div>
            <div class="box">
                <label for="city">City:</label>
                <input type="text" name="city" id="city" class="form-control" value="{{$user->city}}" disabled>
            </div>
        </div>
        <div class="col">
            <div class="box">
                <label for="state">State:</label>
                <input type="text" name="state" id="state" class="form-control" value="{{$user->state}}" disabled>
            </div>
            <div class="box">
                <label for="date">Created Date:</label>
                <input type="text" name="date" id="date" class="form-control" value="{{$user->created_at}}" disabled>
            </div>
            <div class="box">
                <label for="country">Country:</label>
                <input type="text" name="country" id="country" class="form-control" value="{{$user->country}}" disabled>
            </div>
            <div class="box">
                <label for="phone">Phone No:</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{$user->phoneno}}" disabled>
            </div>
        </div>
    
        
    </div>
@endsection
