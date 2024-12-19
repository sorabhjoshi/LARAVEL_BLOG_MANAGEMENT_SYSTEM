@extends('Blogbackend.components.layout')

@section('title', __('Forbidden'))
@section('content')
    <div class="error-page" style="background-color: black; color: white; height: 100vh; display: flex; justify-content: center; align-items: center; text-align: center;">
        <div>
            <h1>{{ __('Forbidden') }}</h1>
            <h2>403</h2>
            <p>{{ __($exception->getMessage() ?: 'You do not have permission to access this page.') }}</p>
            <a href="{{ route('home') }}" class="btn btn-primary" style="color: white; background-color: #007bff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Go to Home</a>
        </div>
    </div>
@endsection
