@extends('Blogbackend.components.layout')

@section('title', 'Edit Menu')

@section('content')
<form action="{{ route('updatemenu', $menu->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="category">Category</label>
    <input type="text" name="category" value="{{ $menu->category }}" required>

    <label for="permission">Permission</label>
    <input type="text" name="permission" value="{{ $menu->permission }}" required>

    <button type="submit">Update Menu</button>
</form>
@endsection
