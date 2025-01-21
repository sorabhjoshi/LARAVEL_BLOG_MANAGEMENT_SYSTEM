@extends('Blogbackend.components.layout')
@section('title', 'City List')
@section('content')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">

<div class="container mt-4">
    <div class="d-flex justify-content-between">
        <h2>City List</h2>
        <a href="{{ route('Dashboardfront') }}" class="btn btn-primary">View Site</a>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Filter Section -->
    <div class="filter-container mt-3">
        <h4>Filter</h4>
        <div class="d-flex align-items-center">
            <label for="startDate" class="me-2">Start Date:</label>
            <input type="date" id="startDate" class="form-control me-3">
            <label for="endDate" class="me-2">End Date:</label>
            <input type="date" id="endDate" class="form-control me-3">
            <button id="filterButton" class="btn btn-primary">Filter</button>
        </div>
    </div>

    <!-- City Table -->
    <table id="city-table" class="table table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>City Name</th>
                <th>Slug</th>
                <th>Is Capital</th>
                <th>Currency</th>
                <th>Created Date</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Add/Edit Modal -->
<div class="modal" id="cityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cityModalLabel">Add/Edit City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cityForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">City Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <input type="hidden" id="cityId">
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug">
                    </div>
                    <div class="mb-3">
                        <label for="is_capital" class="form-label">Is Capital</label>
                        <select class="form-control" id="is_capital" name="is_capital">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="currency" class="form-label">Currency</label>
                        <input type="text" class="form-control" id="currency" name="currency">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Initialize DataTable
    const table = $('#city-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/getCityAjax',
            type: 'POST',
            data: function (d) {
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
            },
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'is_capital', name: 'is_capital' },
            { data: 'currency', name: 'currency' },
            { data: 'created_date', name: 'created_date' },
            { data: 'edit', orderable: false, searchable: false },
            { data: 'delete', orderable: false, searchable: false },
        ],
        "pageLength": 5,
        "lengthMenu": [5, 10, 15, 20],
        "drawCallback": function(settings) {
            // Reinitialize the modal for editing and deleting after every draw
            attachEditDeleteButtons();
        }
    });

    // Trigger filter on button click
    $('#filterButton').on('click', function () {
        table.ajax.reload();
    });

    // Handle form submission (Add/Edit)
    $('#cityForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#cityId').val();
        const url = id ? `/city/update/${id}` : '/city/store';
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url,
            type: method,
            data: {
                name: $('#name').val(),
                slug: $('#slug').val(),
                is_capital: $('#is_capital').val(),
                currency: $('#currency').val(),
            },
            success: (response) => {
                $('#cityModal').modal('hide');
                table.ajax.reload();
                alert(response.success);
            },
            error: (xhr) => {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    // Edit City (show modal with existing data)
    $('#city-table').on('click', '.editCity', function () {
        const id = $(this).data('id');
        $.get(`/city/${id}`, (data) => {
            $('#cityId').val(data.id);
            $('#name').val(data.name);
            $('#slug').val(data.slug);
            $('#is_capital').val(data.is_capital);
            $('#currency').val(data.currency);
            $('#cityModalLabel').text('Edit City');
            $('#cityModal').modal('show');
        });
    });

    // Delete City
    $('#city-table').on('click', '.deleteCity', function () {
        if (confirm('Are you sure you want to delete this city?')) {
            const id = $(this).data('id');
            $.ajax({
                url: `/city/delete/${id}`,
                type: 'DELETE',
                success: (response) => {
                    table.ajax.reload();
                    alert(response.success);
                },
                error: (xhr) => {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        }
    });

    // Attach edit and delete buttons after every table redraw
    function attachEditDeleteButtons() {
        $('#city-table').find('.editCity').each(function () {
            $(this).on('click', function () {
                const id = $(this).data('id');
                $.get(`/city/${id}`, (data) => {
                    $('#cityId').val(data.id);
                    $('#name').val(data.name);
                    $('#slug').val(data.slug);
                    $('#is_capital').val(data.is_capital);
                    $('#currency').val(data.currency);
                    $('#cityModalLabel').text('Edit City');
                    $('#cityModal').modal('show');
                });
            });
        });

        $('#city-table').find('.deleteCity').each(function () {
            $(this).on('click', function () {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this city?')) {
                    $.ajax({
                        url: `/city/delete/${id}`,
                        type: 'DELETE',
                        success: (response) => {
                            table.ajax.reload();
                            alert(response.success);
                        },
                        error: (xhr) => {
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    }
</script>
@endsection
