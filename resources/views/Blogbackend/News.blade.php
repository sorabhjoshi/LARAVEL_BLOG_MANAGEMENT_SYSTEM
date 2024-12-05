@extends('Blogbackend.components.layout')


@section('title', 'Home Page')

@section('content')
    <h1>Welcome to the news Page</h1>
    <p>This is the content of the home page.</p>
    @php
    $user = session('user');
@endphp

@if ($user)
    <p>Welcome, {{ $user->name }}!</p>
    <p>Your email is {{ $user->email }}</p>
@else
    <p>No user data available.</p>
@endif
@endsection
