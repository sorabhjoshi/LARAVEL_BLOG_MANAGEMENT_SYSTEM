@extends('Blogbackend.components.layout')

@section('content')
<div class="form-container">
    <h2>Edit User Details</h2>
    
            
        
    <form action="{{ route('updateuser', $userdata->id) }}" method="POST">
        @csrf
        @method('PUT') 
        
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{  $userdata->name }}" >
            @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $userdata->email}}" >
            @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group">
            <label for="phoneno">Phone Number:</label>
            <input type="text" id="phone_no" name="phoneno" value="{{ $userdata->phoneno }}" >
            @error('phoneno')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="{{  $userdata->gender }}" >
            @error('gender')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="{{  $userdata->city }}" >
            @error('city')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group">
            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="{{  $userdata->state }}" >
            @error('state')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" value="{{  $userdata->country }}" >
            @error('country')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group full-width">
            <button type="submit">Update User</button>
        </div>
    </form>
</div>
  <style>
    /* Wrapper for the entire content */
    .content {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background-color: #f1f1f1;
        min-height: 100vh;
    }
    .error-message {
        color: red;   
        font-size: 14px;  
        margin-top: 5px;  
    }
    .text-danger{
        color: red;   
        font-size: 14px;  
        margin-top: 5px;
    }
   
    .form-container {
        width: 90%;
        max-width: 600px;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Heading styling */
    h2 {
        text-align: center;
        color: #333;
        font-size: 26px;
        margin-bottom: 20px;
    }
    
    /* Form styling */
    form {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
    }
    
    /* Label styling */
    label {
        font-size: 16px;
        font-weight: bold;
        color: #444;
        margin-bottom: 5px;
    }
    
    /* Input styling */
    input[type="text"],
    input[type="email"],
    input[type="number"] {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f4f4f4;
        transition: border-color 0.3s ease, background-color 0.3s ease;
    }
    
    /* Input focus effect */
    input:focus {
        border-color: #4CAF50;
        background-color: #fff;
        outline: none;
    }
    
    /* Full-width button */
    .full-width {
        grid-column: span 2;
        display: flex;
        justify-content: center;
    }
    
    button {
        padding: 12px 24px;
        font-size: 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    /* Button hover effect */
    button:hover {
        background-color: #45a049;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        form {
            grid-template-columns: 1fr;
        }
    
        h2 {
            font-size: 22px;
        }
    }
    </style>
@endsection
