
@extends('Blogbackend.components.layout')

@section('content')
    <style>
        /* Custom Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-buttons a, .action-buttons button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .action-buttons button {
            background-color: #dc3545;
        }
            .action-buttons a{
            text-decoration: none;
        }
            h1{
            padding: 10px;
            background-color: #4b5c70;
            border-radius: 10px;    
            margin: 10px 0;
            color: white
        }
            .adddata{
            padding: 10px;
            background-color: #4b5c70;
            border-radius: 10px;    
            margin: 10px 0;
            color: white;
            text-decoration: none;
            display: block;
            width: 150px;
            text-align: center;
        }   
        .adddata:hover{
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            }
    </style>
    <div class='container'>
        <h1>List of BlogList</h1>
        <table>
            <thead>
                <tr>
                    <th>{{ ucfirst('id') }}</th>
<th>{{ ucfirst('name') }}</th>
<th>{{ ucfirst('email') }}</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    @foreach ($BlogList as $model)
        <tr>
            @foreach ($columns as $column)
                <td>{{ $model->$column }}</td>
            @endforeach
            <td class='action-buttons'>
                <a href="{{ route(strtolower('BlogList') . '.edit', $model->id) }}"><i class='fas fa-edit'></i></a>
                <form action="{{ route(strtolower('BlogList') . '.destroy', $model->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><i class='fas fa-trash-alt'></i></button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
        </table>
        <a class='adddata' href='{{ route('bloglist.create') }}'>Create New</a>
    </div>
@endsection
