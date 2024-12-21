@extends('Blogbackend.components.layout')

@section('content')
<style>
    /* Custom styling for the form */
    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Full viewport height */
        padding: 20px;
    }

    form {
        background-color: #f9f9f9;
        padding: 30px;
        width: 50%;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-family: 'Oswald', sans-serif;
        font-weight: bold;
        color: #333;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    input, select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .submit-btn {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }

    span {
        font-size: 12px;
        color: red;
    }
</style>

<div class="form-container">
    <form method="POST" action="{{ route('addmenutabledata') }}" enctype="multipart/form-data">
        @csrf
        <h2>Menu Bar</h2>

        <div class="form-group">
            <label for="category">Menu For</label>
            <select id="category" name="category">
                <option value="" disabled selected>Select a category</option>
                <option value="admin">Admin</option>
                <option value="frontend">Frontend</option>
            </select>
            <span>@error("category"){{$message}}@enderror</span>
        </div>

        <div class="form-group">
            <label for="permission">Permission</label>
            <input type="text" name="permission">
            <span>@error("permission"){{$message}}@enderror</span>
        </div>

        <button type="submit" class="submit-btn">Submit</button>
    </form>
</div>
@endsection
