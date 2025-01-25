
@extends('Blogbackend.components.layout')

@section('content')
    <style>
        /* Custom Styles */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type='text'] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type='submit'] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .containercreate{
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        button[type='submit']:hover {
            background-color: #218838;
        }
    </style>
    <div class='containercreate'>
        <h1>Create BlogList</h1>
        <form action='{{ route('bloglist.store') }}' method='POST'>
            @csrf
            <input type='hidden' name='id' value='{{ isset($BlogList) ? $BlogList->id : '' }}'>

        <div class='form-group'>
            <label for='name'>{{ ucfirst('name') }}</label>
            <input type='text' name='name' id='name' value='{{ isset($BlogList) ? $BlogList->name : '' }}' class='form-control' required>
        </div>

        <div class='form-group'>
            <label for='email'>{{ ucfirst('email') }}</label>
            <input type='text' name='email' id='email' value='{{ isset($BlogList) ? $BlogList->email : '' }}' class='form-control' required>
        </div>
            <button type='submit'>Create</button>
        </form>
    </div>
@endsection
