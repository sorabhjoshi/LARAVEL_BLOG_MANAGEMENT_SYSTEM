
@extends('Blogbackend.components.layout')

@section('content')
    <div class='container'>
        <h1>Create Company</h1>
        <form action='{{ route('company.store') }}' method='POST'>
            @csrf
            <label for='name'>{{ ucfirst('name') }}</label><input type='text' name='name' id='name' required>
<label for='email'>{{ ucfirst('email') }}</label><input type='text' name='email' id='email' required>
<label for='created_at'>{{ ucfirst('created_at') }}</label><input type='text' name='created_at' id='created_at' required>
            <button type='submit'>Create</button>
        </form>
    </div>
@endsection
