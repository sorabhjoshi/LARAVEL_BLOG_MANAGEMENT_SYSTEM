@extends('Blogbackend.components.layout')
@section('title', 'Update Profile')

@section('content')
@php
    $user = session('user');
@endphp
<link rel="stylesheet" href="{{ asset('css/updateprofile.css') }}">
<h1>Update Details</h1>
<div class="profilecontainer">
    <form action="/updateprofile" method="post">
        @csrf
    <div class="blah">
       
        <div class="col">
            <div class="box">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}">
            </div>
            <div class="box">
                <label for="gender">Gender:</label>
                <input type="text" name="gender" id="gender" class="form-control" value="{{$user->gender}}" >
            </div>
            <div class="box">
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" class="form-control" value="{{$user->email}}">
            </div>
            <div class="box">
                <label for="city">City:</label>
                <input type="text" name="city" id="city" class="form-control" value="{{$user->city}}">
            </div>
            
        </div>
        
        <div class="col">
            <div class="box">
                <label for="state">State:</label>
                <input type="text" name="state" id="state" class="form-control" value="{{$user->state}}">
            </div>
            <div class="box">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" >
            </div>
            <div class="box">
                <label for="country">Country:</label>
                <input type="text" name="country" id="country" class="form-control" value="{{$user->country}}">
            </div>
            <div class="box">
                <label for="phone">Phone No:</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{$user->phoneno}}">
            </div>
          
        </div>
    </div>
    <button class="update" type="submit">Update</button>
</form>
</div>
    
@endsection
