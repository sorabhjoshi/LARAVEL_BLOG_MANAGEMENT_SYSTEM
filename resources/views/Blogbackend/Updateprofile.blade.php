@extends('Blogbackend.components.layout')
@section('title', 'Update Profile')

@section('content')
<style>
    .content {
        padding: 30px 30px 0 30px;
        flex-grow: 1;
        width: 50vw;
        margin: 20px auto;
        border-radius: 7px;
        background-color: #e0e0e0;
    }
    .profilecontainer {
        padding-bottom: 30px; /* Add space at the bottom */
    }
    .form-group {
        margin-bottom: 15px;
    }
    .btn-submit {
        margin-top: 20px;
        padding: 10px 20px;
    }
    .alert-danger {
        margin-bottom: 20px;
    }
</style>

@php
   $user = Auth::user();
@endphp

<link rel="stylesheet" href="{{ asset('css/updateprofile.css') }}" method="post">

<h1>My Details</h1>

<div class="profilecontainer">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/updateprofile">
        @csrf
        <div class="row gap-3">
            <div class="col-md-12">
                <div class="form-group"> 
                    <strong>Name:</strong>
                    <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $user->name }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" placeholder="Email" class="form-control" value="{{ $user->email }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Password:</strong>
                    <input type="password" name="password" placeholder="Password" class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Role:</strong>
                    <select name="roles[]" class="form-control" multiple="multiple">
                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}" {{ isset($userRole[$value]) ? 'selected' : ''}}>
                                {{ $label }}
                            </option>
                         @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> Submit
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
