@extends('Backend.layouts.app')
<link rel="stylesheet" href="{{ asset('css/Backend/create.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@section('content')
<main id="main" class="main">
    <h1 class="header">Create Testing</h1>
    <form class="simple" method="post" action="/Testing/store" enctype="multipart/form-data">
        <div class="form1">
            @csrf
            
            <button type="submit" class="btn btn-primary">Submit</button>
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