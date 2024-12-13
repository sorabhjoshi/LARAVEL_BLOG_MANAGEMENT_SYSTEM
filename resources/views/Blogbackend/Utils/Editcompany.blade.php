@extends('Blogbackend.components.layout')

@section('content')
<link rel="stylesheet" href='{{asset('css/addblogcat.css')}}'>
<div class="form-container">
    <h2>Edit Company Data</h2>
    
    <form action="/UpdateCompanyData" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="id" name="id" value='{{$userdata->id}}'>
        @error('id')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="name">Company Name:</label>
        <input type="text" id="name" name="name" value='{{$userdata->name}}'>
        @error('name')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" value='{{$userdata->type}}'>
        @error('type')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="email">E-mail:</label>
        <input type="text" id="email" name="email" value='{{$userdata->email}}'>
        @error('email')
                    <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="form-group full-width">
            <button type="submit">Add Company</button>
        </div>
    </form>
</div>
@endsection
