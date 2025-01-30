@extends('Blogbackend.components.layout')
<link rel="stylesheet" href="{{ asset('css/Backend/blog.css') }}">
<?php
use Illuminate\Support\Facades\DB;
?>
@section('content')
<div class="info" style="background: white;">
<div class="container mt-4">
    <h2>Testing List</h2>
<a href="{{ '/' . lcfirst('Testing') . '/create' }}" class="btn btn-primary">Add Testing</a>
<table id="table">
    <thead>
        <tr>
        </div>
        </div><th>Department_name</th><th>Created_at</th><th>Updated_at</th><th>Actions</th></tr></thead><tbody>    @foreach($data as $row)
    <tr><td>{{ $row->department_name }}</td><td>{{ $row->created_at }}</td><td>{{ $row->updated_at }}</td>            <td>
                <a href="{{ '/' . 'Testing' . '/edit/' . $row->id }}" class="btn btn-warning">Edit</a>
                <form action="{{ '/' . 'Testing' . '/delete/' . $row->id }}" method="POST" style="display:inline;">
                @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Open file manager on button click
    document.getElementById('button-image').addEventListener('click', (event) => {
        event.preventDefault();
        window.open('/file-manager/fm-button', 'fm', 'width=700,height=400');
    });
});

// Set image link after selection from file manager
function fmSetLink($url) {
    const modifiedUrl = $url.replace(/^https?:\/\/[^\/]+\//, ''); // Removes protocol and domain
    document.getElementById('image').value = modifiedUrl; // Set value to the image input field
}
</script>
@endsection