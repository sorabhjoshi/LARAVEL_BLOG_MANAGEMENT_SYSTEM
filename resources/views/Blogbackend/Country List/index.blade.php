@extends('Blogbackend.components.layout')
@section('title', 'Country List')
@section('content')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">

<div class="container mt-4">
    <div class="addnews d-flex justify-content-between">
        <h2>Country List</h2>
        <div>
            <a href="{{ route('Dashboardfront') }}" class="btn btn-primary me-2">View Site</a>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="filter-container mt-3">
        <h4>Filter</h4>
        <div class="filter d-flex align-items-center">
            <label for="startDate" class="me-2">Start Date:</label>
            <input type="date" id="startDate" class="form-control me-3">
            <label for="endDate" class="me-2">End Date:</label>
            <input type="date" id="endDate" class="form-control me-3">
            <button id="filterButton" class="btn btn-primary">Filter</button>
        </div>
    </div>
    <table id="user-table" class="user-table table table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Country Name</th>
                <th>Continent</th>
                <th>Phone Code</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Add/Edit Modal -->
<div class="modal" id="countryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="countryModalLabel">Add/Edit Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="countryForm">
                    <div class="mb-3">
                        <label for="countryname" class="form-label">Country Name</label>
                        <input type="text" class="form-control" id="countryname" name="countryname">
                        <input type="hidden" id="countryId">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // DataTable Initialization
        const table = $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/getcountryAjax',
                type: 'POST',
                data: function (d) {
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                }
            },
            pageLength: 5,
            columns: [
                { data: null, render: (data, type, row, meta) => meta.row + 1 + meta.settings._iDisplayStart },
                { data: 'name', name: 'name' },
                { data: 'continent', name: 'continent' },
                { data: 'phone_code', name: 'phone_code' },
                { data: 'edit', orderable: false, searchable: false },
                { data: 'delete', orderable: false, searchable: false },
            ],
        });

        // Filter Action
        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });

        // Show Add Modal
        $('#addcountry').on('click', function () {
            $('#countryForm')[0].reset();
            $('#countryId').val('');
            $('#countryModalLabel').text('Add Country');
            $('#countryModal').modal('show');
        });

        // Save Country (Add/Edit)
        $('#countryForm').on('submit', function (e) {
            e.preventDefault();
            const id = $('#countryId').val();
            const url = id ? `/country/update/${id}` : '/country/store';
            const method = id ? 'PUT' : 'POST';
            const data = { countryname: $('#countryname').val() };

            $.ajax({
                url,
                type: method,
                data,
                success: (response) => {
                    $('#countryModal').modal('hide');
                    table.ajax.reload();
                    alert(response.success);
                },
                error: (xhr) => {
                    alert('Error: ' + xhr.responseJSON.message);
                },
            });
        });

        // Edit Country
        $('#user-table').on('click', '.editCountry', function () {
            const id = $(this).data('id');
            $.get(`/country/${id}`, (data) => {
                $('#countryId').val(data.id);
                $('#countryname').val(data.countryname);
                $('#countryModalLabel').text('Edit Country');
                $('#countryModal').modal('show');
            });
        });

        // Delete Country
        $('#user-table').on('click', '.deleteCountry', function () {
            if (confirm('Are you sure you want to delete this country?')) {
                const id = $(this).data('id');
                $.ajax({
                    url: `/country/delete/${id}`,
                    type: 'DELETE',
                    success: (response) => {
                        table.ajax.reload();
                        alert(response.success);
                    },
                    error: (xhr) => {
                        alert('Error: ' + xhr.responseJSON.message);
                    },
                });
            }
        });
    });
</script>
@endsection
