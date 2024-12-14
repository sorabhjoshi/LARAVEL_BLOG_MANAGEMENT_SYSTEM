@extends('Blogbackend.components.layout')

@section('content')


<link rel="stylesheet" href='{{asset('css/addblog.css')}}'>
<div class="form-container">
    <h2>Add Blog</h2>
    <form action="/AddBlog" method="post" enctype="multipart/form-data">
        @csrf
        <label for="author_name">Author Name:</label>
        <input type="text" id="author_name" name="author_name" >
        @error('author_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" >
        @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" >
        @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

        <label for="content">Content:</label>
        <textarea id="description" name="content"></textarea>
        @error('content')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="category">Category:</label>
        <select id="Category" name="category" >
            <option value="" disabled selected>Select Category</option>
            @foreach ($Catdata as $item)
            <option value="{{ $item->id }}">{{ $item->categorytitle }}</option>
            @endforeach
        </select>
        @error('category')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <div class="form-group full-width">
            <button type="submit">Add Blog</button>
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