@extends('Blogbackend.components.layout')

@section('content')


<link rel="stylesheet" href='{{asset('css/addblog.css')}}'>
<div class="form-container">
    <h2>Edit Blog</h2>
    
    <form action="/UpdateBlog" method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" id="id" name="id" value={{$userdata->id}}>
        @error('id')
        <div class="text-danger">{{ $message }}</div>
        @enderror


        <label for="author_name">Author Name:</label>
        <input type="text" id="author_name" name="author_name" value={{$userdata->authorname}}>
        @error('author_name')
                <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value={{$userdata->title}}>
        @error('title')
                <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" value={{$userdata->image}}>
        @error('image')
                <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="content">Content:</label>
        <textarea id="description" name="content"> {{$userdata->description}}</textarea>
        @error('content')
                <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="category">Category:</label>
        <select id="Category" name="category" >
<<<<<<< HEAD
            <option value="{{$userdata->category}}"  selected >Selected</option>
=======
            <option value="value={{$userdata->authorname}}"  selected >{{$userdata->authorname}}</option>
>>>>>>> 021908dff41cbfdfe4823b97e24c1226c69e77f2
            @foreach ($Catdata as $item)
            <option value="{{ $item->id }}">{{ $item->categorytitle }}</option>
        @endforeach
        </select>
        @error('category')
                <div class="text-danger">{{ $message }}</div>
        @enderror

        <div class="form-group full-width">
            <button type="submit">update Blog</button>
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