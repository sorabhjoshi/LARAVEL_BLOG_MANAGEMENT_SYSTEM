@extends('Blogbackend.components.layout')

@section('title', 'Edit Menu')

@section('content')
<style>
    /* Custom styling for the form */
    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        /* width: 100vw; */
        text-align: center;
        height: 100vh; /* Full viewport height */
    }

    form {
        background-color: #f9f9f9;
        padding: 30px;
        text-align: left;
        /* width: 50%; */
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-family: 'Oswald', sans-serif;
        font-weight: bold;
        color: #333;
        
    }

    button[type="submit"] {
        width: 100%;
    }
</style>

<div class="form-container">
    <div>
        <h2>Edit Menu</h2>
        <form action="{{ route('updatemenu', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" name="category" value="{{ $menu->category }}" required>
            </div>

            <div class="form-group">
                <label for="permission">Permission</label>
                <input type="text" class="form-control" name="permission" value="{{ $menu->permission }}" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Menu</button>
        </form>
    </div>
</div>
@endsection
