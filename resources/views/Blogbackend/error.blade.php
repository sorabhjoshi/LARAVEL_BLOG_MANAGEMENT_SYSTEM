@extends('Blogbackend.components.layout')

@section('title', 'Forbidden - 403')

@section('content')
    <div class="error-message">
        <h1>403 Forbidden</h1>
        <p>You do not have the right roles to access this page.</p>
    </div>
@endsection
