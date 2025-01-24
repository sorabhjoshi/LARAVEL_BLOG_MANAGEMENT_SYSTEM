
@extends('Blogbackend.components.layout')

@section('content')
    <div class='container'>
        <h1>List of Company</h1>
        <table>
            <thead>
                <tr>
                    <th>{{ ucfirst('name') }}</th>
<th>{{ ucfirst('email') }}</th>
<th>{{ ucfirst('created_at') }}</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
               
    @foreach ($Company as $model)
        <tr>
            @foreach ($columns as $column)
                <td>{{ $model[$column] }}</td>
            @endforeach
            <td>
                <a href="{{ route(strtolower('Company') . '.edit', $model->id) }}">Edit</a>
                <form action="{{ route(strtolower('Company') . '.destroy', $model->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
        </table>
        <a href='{{ route('company.create') }}'>Create New</a>
    </div>
@endsection
