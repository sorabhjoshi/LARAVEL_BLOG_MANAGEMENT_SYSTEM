@extends('Blogbackend.components.layout')

@section('content')
<style>
    .dropdown-menu {
    display: none;
    position: static !important; 
    width: 100%;
    transform: none !important;
    background-color: transparent;
    box-shadow: none;
    border: none;
}
.box{
    height: 300px !important;
    box-sizing: border-box;
    overflow: hidden;
}
.dropdown-menu.show {
    display: block;
}

.dropdown-toggle{
    background-color: transparent;
    border: none;
    color:#565454;
}
    .box {
        padding: 30px 30px 0 30px;
        flex-grow: 1;
        width: 30vw;
        margin: 23vh auto;
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
<div class="box">
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

       
       

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mb-3">
                <i class="fa-solid fa-floppy-disk"></i> Submit
            </button>
        </div>
    </div>
</form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
