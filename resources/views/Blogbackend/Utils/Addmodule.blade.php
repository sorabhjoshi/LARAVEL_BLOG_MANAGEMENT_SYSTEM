@extends('Blogbackend.components.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/addblogcat.css') }}">
<style>
.containerz {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>

<div class="containerz">
    <h2>Add Modules</h2>
    <form method="POST" action="{{ route('generate.mvc') }}">
        @csrf

        <label for="model">Model Name:</label>
        <input type="text" id="model" name="model" placeholder="Model Name" required>
        <br><br>

        <label for="view">View</label>
        <input type="text" id="view" name="view" placeholder="View Folder Name" required>
        <br><br>

        <label for="route">Route Name:</label>
        <input type="text" id="route" name="route" placeholder="Route Name" required>
        <br><br>
        <button type="submit" class="btn btn-success">Save Module</button>
    </form>
</div>

@endsection
