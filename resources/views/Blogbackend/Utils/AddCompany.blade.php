@extends('Blogbackend.components.layout')

@section('content')
<link rel="stylesheet" href='{{asset('css/addblogcat.css')}}'>
<div class="form-container">
    <h2>Add Company Data</h2>
    
    <form action="/AddCompanyData" method="post" enctype="multipart/form-data">
        @csrf

        <label for="name">Company Name:</label>
        <input type="text" id="name" name="name" >
        @error('name')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" >
        @error('type')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="email">E-mail:</label>
        <input type="text" id="email" name="email" >
        @error('email')
                    <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="form-group full-width">
            <button type="submit">Add Company</button>
        </div>
    </form>
</div>
@endsection
