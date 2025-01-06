@extends('Blogbackend.components.layout')
<style>/* General Styling */
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
@section('content')

<link rel="stylesheet" href='{{ asset('css/addblogcat.css') }}'>
<div class="form-container">
    <h2>Add Designation</h2>

    <form action="/AddDesignationData" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="Department">Department:</label>
            <select name="Department" id="Department">
                @foreach ($depname as $item)
                    <option value="{{$item->id}}">{{$item->department_name}}</option>
                @endforeach
            </select>
            @error('Department')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Designation">Designation:</label>
            <input type="text" id="Designation" name="Designation" placeholder="Enter designation" value="">
            @error('Designation')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Level"> Select Level:</label>
            <select name="Level" id="Level">
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

        <div class="form-group full-width">
            <button type="submit">Add Designation</button>
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
