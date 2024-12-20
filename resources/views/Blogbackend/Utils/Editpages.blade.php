@extends('Blogbackend.components.layout')

@section('content')
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
<link rel="stylesheet" href='{{asset('css/addblogcat.css')}}'>
<div class="form-container">
    <h2>Edit Page</h2>
    
    <form action="/UpdatePageData" method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" id="id" name="id" value="{{$userdata ->id }}">
        @error('id')
        <div class="text-danger">{{ $message }}</div>
        @enderror


        <label for="authorname">Author Name:</label>
        <input type="text" id="authorname" name="authorname" value="{{$userdata ->author }}">
        @error('authorname')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{$userdata ->title }}">
        @error('title')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="description">Content:</label>
        <textarea id="description" name="description">{{$userdata ->description }}</textarea>
        @error('description')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <div class="form-group full-width">
            <button type="submit">Add Category</button>
        </div>
    </form>
</div>
@endsection
