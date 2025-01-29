@extends('Backend.layouts.app')
<link rel="stylesheet" href="{{ asset('css/Backend/blog.css') }}">
@section('content')
<div class="info" style="background: white;">
<div class="container mt-4">
    <h2>Testing List</h2>
<a href="/Testing/create" class="btn btn-primary">Add Testing</a>
<table id="table">
    <thead>
        <tr>
        </div>
        </div><th>Name</th><th>Actions</th></tr></thead><tbody>    @foreach($data as $row)
    <tr><td>{{ $row->name }}</td>            <td>
                <a href="/Testing/edit/{{ $row->id }}" class="btn btn-warning">Edit</a>
                <form action="/Testing/delete/{{ $row->id }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection