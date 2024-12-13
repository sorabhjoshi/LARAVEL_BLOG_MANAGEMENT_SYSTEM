@extends('layouts.app')

@section('content')
<?php $userId = session('user_id');
 ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: #aae698">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>Welcome, {{ session('user_name') }}!</p>

                    {{ __('You are logged in!') }}
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
