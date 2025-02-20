@extends('Blogbackend.components.layout')

@section('content')


<link rel="stylesheet" href='{{asset('css/addblog.css')}}'>
<div class="form-container">
    <h2>Add News</h2>
    
    <form action="/AddDomain" method="post" enctype="multipart/form-data">
        @csrf
        <label for="domainname">Domainname:</label>
        <input type="text" id="domainname" name="domainname" placeholder="Enter domainname">
        @error('domainname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

        <label for="companyname">Companyname:</label>
        <input type="text" id="companyname" name="companyname" placeholder="Enter companyname">
        @error('companyname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

        <label for="mail_header">Mail_header:</label>
        <textarea name="mail_header" id="description" cols="30" rows="10"></textarea>
        @error('mail_header')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

        <label for="mail_footer">Mail_footer:</label>
        <textarea id="description" name="mail_footer"></textarea>
        @error('mail_footer')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="port">server_address:</label>
        <input type="text" id="server_address" name="server_address" placeholder="Enter server address">
        @error('server_address')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="authentication">authentication:</label>
        <input type="text" id="authentication" name="authentication" placeholder="Enter authentication">
        @error('port')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="port">Port:</label>
        <input type="text" id="port" name="port" placeholder="Enter port">
        @error('port')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter username">
        @error('username')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter password">
        @error('password')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="tomail_id">To mail_id:</label>
        <input type="email" id="tomail_id" name="tomail_id" placeholder="Enter mail_id">
        @error('tomail_id')
                    <div class="text-danger">{{ $message }}</div>
        @enderror


        <div class="form-group full-width">
            <button type="submit">Add Domain</button>
        </div>
    </form>
</div>
@endsection
@section('js')
<script src="https://cdn.tiny.cloud/1/71ai8b7zzyf1jrb5kikhfovyrho0d7arpvrutm5n4hddovi8/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#description',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        height: 200
    });
</script>
@endsection

