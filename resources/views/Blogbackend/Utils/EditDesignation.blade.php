@extends('Blogbackend.components.layout')

@section('content')
<link rel="stylesheet" href='{{ asset('css/addblogcat.css') }}'>
<div class="form-container">
    <h2>Edit Designation</h2>

    <form action="{{ route('updateDesignationData', $designation->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT') 

        <div class="form-group">
            <label for="Department">Department:</label>
            <select name="Department" id="Department">
                <option value="{{$designation->department_id}}" disabled selected>{{$designation->departments->department_name}}</option>
                @foreach ($departments as $item)
                    <option value="{{$item->id}}">{{$item->department_name}}</option>
                @endforeach
            </select>
            @error('Department')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <input type="hidden" name="id" value="{{$designation->id}}">

        <div class="form-group">
            <label for="Designation">Designation:</label>
            <input type="text" id="Designation" name="Designation" placeholder="Enter designation" value="{{$designation->designation_name}}">
            @error('Designation')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Level"> Select Level:</label>
            <select name="Level" id="Level">
                <option value="{{$designation->level}}" disabled selected>{{$designation->level}}</option>
                <option value="Level1">Level 1</option>
                <option value="Level2">Level 2</option>
                <option value="Level3">Level 3</option>
                <option value="Level4">Level 4</option>
                <option value="Level5">Level 5</option>
            </select>
            @error('Level')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit">Update Designation</button>
        </div>
    </form>
</div>

@endsection

@section('js')

@endsection

<style>
/* General Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
}

.form-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 30px auto;
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

/* Form Elements */
.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-size: 16px;
    color: #333;
    margin-bottom: 8px;
}

select, input[type="text"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="text"]:focus, select:focus {
    border-color: #007bff;
    outline: none;
}

button {
    background-color: #007bff;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}

/* Error Styling */
.error-message {
    color: #e74c3c;
    font-size: 14px;
    margin-top: 5px;
}

/* Responsive */
@media (max-width: 768px) {
    .form-container {
        padding: 20px;
    }

    h2 {
        font-size: 20px;
    }

    button {
        font-size: 14px;
    }
}
</style>
