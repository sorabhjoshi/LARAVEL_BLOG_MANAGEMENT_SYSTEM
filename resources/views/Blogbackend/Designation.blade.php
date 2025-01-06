@extends('Blogbackend.components.layout')
@section('title', 'Designations')
@section('content')
<link rel="stylesheet" href='{{asset('css/blog.css')}}'>
<div class="container mt-4">
    <div class="addnews">
        <h2>Designation List</h2>
        <div>
            <a href="{{route('Dashboardfront')}}" class="btn btn-primary me-2">View Site</a>
            <a href="{{route('add_designation')}}" class="btn btn-success">Add Designation</a>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <table id="user-table" class="user-table">
        <div class="filter-container">
            <h4>Filter</h4>
            <div class="filter">
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate">
                <button id="filterButton">Filter</button>
            </div>
        </div>
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Level</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>



@endsection
@section('js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
       
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const table = $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/GetdesignationAjax',
                type: 'POST',
                data: function (d) {
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                }
            },
            pageLength: 5,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1 + meta.settings._iDisplayStart;
                    }
                },
                { data: 'designation_name', name: 'designation_name' },
                { data: 'department_id', name: 'department_id' },
                { data: 'level', name: 'level' },
                { data: 'created_at', name: 'created_at' },
                {
                    data: 'edit', 
                    orderable: false, 
                    searchable: false, 
                    render: function(data, type, row) {
                        return `<a href="/edit-designation/${row.id}" class="btn btn-warning"><i class="fas fa-edit"></i></a>`;
                    }
                },
                {
                    data: 'delete', 
                    orderable: false, 
                    searchable: false, 
                    render: function(data, type, row) {
                        return `<button class="btn btn-danger delete-btn" data-id="${row.id}"><i class="fas fa-trash-alt"></i></button>`;
                    }
                },
            ],
        });

        // Filter Button
        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });

        // Handle Delete button click
        $('#user-table').on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            if (confirm("Are you sure you want to delete this designation?")) {
                $.ajax({
                    url: `/delete-designation/${id}`,
                    type: 'POST',
                    success: function(response) {
                        table.ajax.reload();  // Reload the table data after delete
                    }
                });
            }
        });
    });
</script>

@endsection
