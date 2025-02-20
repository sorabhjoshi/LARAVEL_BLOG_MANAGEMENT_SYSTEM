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
        <img src="{{asset(`$userdata->image`)}}" alt="">
            <input type="text" id="image" class="form-control" name="image" value={{$userdata->image}}"
                   aria-label="Image" aria-describedby="button-image">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="button-image">Select</button>
            </div>
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
            <option value="{{$userdata->category}}"  selected >Selected</option>
            @foreach ($Catdata as $item)
            <option value="{{ $item->id }}">{{ $item->categorytitle }}</option>
        @endforeach
        </select>
        @error('category')
                <div class="text-danger">{{ $message }}</div>
        @enderror
        
        <label for="Domain">Domain:</label>
        <select id="Domain" name="Domain" >
            <option value="" disabled selected>Select Domain</option>
            @foreach ($domain as $item)
            <option value="{{ $item->id }}">{{ $item->domainname }}</option>
            @endforeach
        </select>
        @error('Domain')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="Languages">Languages:</label>
        <select id="Languages" name="Languages" >
            <option value="" disabled selected>Select Languages</option>
            @foreach ($lang as $item)
            <option value="{{ $item->id }}">{{ $item->languages }}</option>
            @endforeach
        </select>
        @error('Languages')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="Country">Country:</label>
        <select id="Country" name="Country">
            <option value="" disabled {{ $userdata->country == null ? 'selected' : '' }}>Select Country</option>
            @foreach ($countries as $item)
                <option value="{{ $item->id }}" {{ $userdata->country == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
            @endforeach
        </select>        
        @error('Country')
                    <div class="text-danger">{{ $message }}</div>
        @enderror

        <div class="form-group full-width">
            <button type="submit">update Blog</button>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();
            window.open('/file-manager/fm-button', 'fm', 'width=700,height=400');
        });
    });
    function fmSetLink($url) {
        const modifiedUrl = $url.replace(/^https?:\/\/[^\/]+\//, ''); 
        document.getElementById('image').value = modifiedUrl; 
    }
</script>
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