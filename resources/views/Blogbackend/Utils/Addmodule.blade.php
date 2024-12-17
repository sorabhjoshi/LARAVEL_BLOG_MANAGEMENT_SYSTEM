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
    <h2>Add Modules</h2>
    <form method="POST" action="{{ route('modulesstore') }}">
        @csrf

        {{-- Module Section --}}
        <div class="module-block mb-4">
            <label for="module_name">Module Name:</label>
            <input type="text" name="module_name" class="form-control mb-2" placeholder="Enter Module Name" >

            {{-- Parent Module Dropdown --}}
            <label for="parent_module">Select Parent Module:</label>
            <select name="parent_module" class="form-control mb-2">
                <option value="">-- No Parent (Main Module) --</option>
                @foreach($modulesdata as $module)
                    <option value="{{ $module->id }}">{{ $module->modulesname }}</option>
                @endforeach
            </select>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-success">Save Module</button>
    </form>
</div>

@endsection
