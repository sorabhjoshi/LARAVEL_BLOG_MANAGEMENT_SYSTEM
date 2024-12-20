@extends('Blogbackend.components.layout')
@section('content')
<form method="POST" action="{{ route('addmenutabledata') }}"enctype="multipart/form-data">
  @csrf
        <h2> Menu Bar</h2>
        <div class="form-group">
            <label for="category">Menu For </label>
            <select id="category" name="category" >
                <option value="" disabled selected>Select a category</option>
                <option value="admin">Admin</option>
                <option value="frontend">Frontend</option>
            </select>
            <span style="color:red">@error("category"){{$message}}@enderror</span>
        </div>
       
        <div class="form-group">
            <label for="Permission">Permission</label>
            <input type="text" name="permission">
            <span style="color:red">@error("permission"){{$message}}@enderror</span>
        </div>

        <button type="submit" class="submit-btn">Submit</button>
    </form>
@endsection