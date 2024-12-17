@extends('Blogbackend.components.layout')

@section('content')
<style>
    .dropdown-menu {
    display: none; /* Hide by default */
    position: static !important; /* Keeps dropdown aligned properly */
    width: 100%;
    transform: none !important;
    background-color: transparent;
    box-shadow: none;
    border: none;
}

.dropdown-menu.show {
    display: block; /* Show as block when Bootstrap adds 'show' */
}

.dropdown-toggle{
    background-color: transparent;
    border: none;
    color:#565454;
}
    .content {
        padding: 30px 30px 0 30px;
        flex-grow: 1;
        width: 50vw;
        margin: 20px auto;
        border-radius: 7px;
        background-color: #e0e0e0;
    }
    .row {
        gap: 20px;
    }
    .dropdown {
        margin-bottom: 10px;
    }
</style>

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('roles.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $role->name }}">
            </div>
        </div>

       
        <div class=" col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permissions:</strong>

                
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="blogsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Blogs
                    </button>
                    <div class="dropdown-menu" aria-labelledby="blogsDropdown">
                        @foreach($permission as $value)
                            @if (Str::startsWith(strtolower($value->name), 'blog'))
                                <div class="dropdown-item">
                                    <input type="checkbox" name="permission[{{ $value->id }}]" value="{{ $value->id }}" 
                                    class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                    {{ $value->name }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- News Dropdown --}}
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="newsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        News
                    </button>
                    <div class="dropdown-menu" aria-labelledby="newsDropdown">
                        @foreach($permission as $value)
                            @if (Str::startsWith(strtolower($value->name), 'news'))
                                <div class="dropdown-item">
                                    <input type="checkbox" name="permission[{{ $value->id }}]" value="{{ $value->id }}" 
                                    class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                    {{ $value->name }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Roles Dropdown --}}
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="rolesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Roles
                    </button>
                    <div class="dropdown-menu" aria-labelledby="rolesDropdown">
                        @foreach($permission as $value)
                            @if (Str::startsWith(strtolower($value->name), 'role'))
                                <div class="dropdown-item">
                                    <input type="checkbox" name="permission[{{ $value->id }}]" value="{{ $value->id }}" 
                                    class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                    {{ $value->name }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mb-3">
                <i class="fa-solid fa-floppy-disk"></i> Submit
            </button>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
