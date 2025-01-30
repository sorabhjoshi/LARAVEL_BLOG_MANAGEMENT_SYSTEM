@extends('Blogbackend.components.layout')
<link rel="stylesheet" href="{{ asset('css/Backend/create.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <?php
use Illuminate\Support\Facades\DB;
?>
@section('content')
<main id="main" class="main">
    <h1 class="header">Create Testing</h1>
    <form class="simple" method="post" action="/Testing/store" enctype="multipart/form-data">
        <div class="form1">
            @csrf
            
                <div class='input-group'>
                    <label>Department_name</label><br>
                    <select class='form-control select2' name='department_name' id='department_name'>
                        <option value=''>Select Department_name</option>
                        @foreach(DB::table('designation')->select('designation_name')->distinct()->get() as $item)
                            <option value='{{ $item->designation_name }}'>
                                {{ $item->designation_name }}
                            </option>
                        @endforeach
                    </select>
                </div> 
                    <div class='input-group'>
                        <label>Created_at</label><br>
                        <input type='date' name='created_at' />
                    </div> 
                    <div class='input-group'>
                        <label>Updated_at</label><br>
                        <input type='date' name='updated_at' />
                    </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</main>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select an option'
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
// Open file manager on button click
document.getElementById('button-image').addEventListener('click', (event) => {
    event.preventDefault();
    window.open('/file-manager/fm-button', 'fm', 'width=700,height=400');
});
});

// Set image link after selection from file manager
function fmSetLink($url) {
const modifiedUrl = $url.replace(/^https?:\/\/[^\/]+\//, ''); // Removes protocol and domain
document.getElementById('image').value = modifiedUrl; // Set value to the image input field
}
</script>
@endsection