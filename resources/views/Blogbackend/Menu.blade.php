@extends('Blogbackend.components.layout')

@section('title', 'Menulist')

@section('content')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">

<div class="news-container">
    <h1 class="news-heading">Menu List</h1>
    <p>
        <a href="{{ route('addmenutable') }}" class="news-link">Add Menu</a>
    </p>
</div>

<div class="table-container">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <table id="blogTable" class="animated-table">
        <thead>
            <tr>
                <th>S no</th>
                <th>Category</th>
                <th>Permission</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Add Menu</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection

@section('js')
<!-- Load DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Initialize DataTables -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    // Ensure that the CSRF token is correctly included
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize DataTable after the page is ready
    $('#blogTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('menudatatable') }}',
            type: 'POST',
        },
        pageLength: 5,
        columns: [
            {
                data: null, // This column is for the auto-incrementing number
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + 1 + meta.settings._iDisplayStart; // Calculate row number
                }
            },
            { data: 'category', name: 'category' },
            { data: 'permission', name: 'permission' },
            { data: 'edit', orderable: false, searchable: false },
            { data: 'delete', orderable: false, searchable: false },
            { data: 'addmenu', orderable: false, searchable: false }
        ],
    });
});
</script>
@endsection

<style>
   
    /* Styling for the container */
.news-container {
    text-align: center;
    margin-bottom: 20px;
}
.navbar{
   padding: 0;
   margin: 0;
   overflow: hidden;
   
}
.table-container{
   width: 99%;
}
.news-heading {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}

/* Styling for the "Add Menu" link */
.news-link {
    font-size: 1.2rem;
    color: #007bff;
    text-decoration: none;
    padding: 10px 20px;
    border: 2px solid #007bff;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

.news-link:hover {
    background-color: #007bff;
    color: white;
}

/* Styling for the table */
.table-container {
    margin-top: 20px;
}

.animated-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.animated-table th, .animated-table td {
    text-align: left;
    padding: 12px;
    border: 1px solid #ddd;
}

.animated-table th {
    background-color: #f4f4f4;
    font-weight: bold;
}

.animated-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.animated-table tr:hover {
    background-color: #f1f1f1;
}

.animated-table td {
    font-size: 1rem;
    color: #555;
}

/* Add a custom style to the DataTables pagination */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border: 1px solid #007bff;
    color: #007bff;
    padding: 5px 10px;
    border-radius: 3px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background-color: #007bff;
    color: white;
}
</style>
