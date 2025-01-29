@extends('Blogbackend.components.layout')
<link rel="stylesheet" href="{{ asset('css/Backend/create.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php
use Illuminate\Support\Facades\DB;


?>
@section('content')
<main id="main" class="main">
    <h1 class="header">Edit Testing</h1>
    <form class="simple" method="post" action="/Testing/update" enctype="multipart/form-data">
        <div class="form1">
            @csrf
            @method('POST')
            <input type="hidden" name="tablename" value="testing">
            <input type='hidden' name='id' value='{{ $text->id }}' />
                <div class='input-group'>
                    <label>Name</label><br>
                    <select class='form-control select2' name='name' id='name'>
                        <option value=''>Select Name</option>
                        @foreach(DB::table('designation')->select('designation_name')->distinct()->get() as $item)
                            <option value='{{ $item->designation_name }}'>
                                {{ $item->designation_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select an option'
        });
    });
</script>
@endsection