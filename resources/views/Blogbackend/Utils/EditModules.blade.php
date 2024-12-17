@extends('Blogbackend.components.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/addblogcat.css') }}">
<style>
.containerz {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>

<div class="containerz">
    <h2>Edit Module</h2>
    <form method="POST" action="{{ route('moduleedit') }}">
        @csrf
        <div class="module-block mb-4">
            <label for="module_name">Module Name:</label>
            <input type="text" name="module_name" class="form-control mb-2" placeholder="Enter Module Name" value="{{ $module->modulesname }}">
            
            <input type="hidden"  name="id"  value="{{ $module->id }}">

            <label for="parent_module">Select Parent Module:</label>
            <select name="parent_module" class="form-control mb-2">
                @if ($parentname)
                <option value="{{$parentname->id}}" selected>{{$parentname->modulesname}}</option>
                @else
                <option value="">-- No Parent (Main Module) --</option>
                @endif
                
                @foreach($modulesdata as $mod)
                    <option value="{{ $mod->id }}">{{ $mod->modulesname }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Save Module</button>
    </form>
</div>

@endsection
