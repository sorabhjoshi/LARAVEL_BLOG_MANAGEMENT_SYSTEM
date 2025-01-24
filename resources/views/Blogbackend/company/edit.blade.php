
@extends('Blogbackend.components.layout')

@section('content')
    <div class='container'>
        <h1>Edit Company</h1>
        <form action='{{ route('company.update', $model->id) }}' method='POST'>
            @csrf
            @method('PUT')
            <label for='name'>{{ ucfirst('name') }}</label><input type='text' name='name' id='name' required>
<label for='email'>{{ ucfirst('email') }}</label><input type='text' name='email' id='email' required>
<label for='created_at'>{{ ucfirst('created_at') }}</label><input type='text' name='created_at' id='created_at' required>
            <button type='submit'>Update</button>
        </form>
    </div>
@endsection
