@extends('Blogbackend.components.layout')
@section('title', 'State List')
@section('content')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">

<div class="container mt-4">
    <div class="addnews d-flex justify-content-between">
        <h2>State List</h2>
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

    <table id="state-table" class="user-table table table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit State</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-control" id="editStatus" name="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
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
        const table = $('#state-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('stateList.getStatesAjax') }}",
                type: 'POST',
                data: function (d) {
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'is_active', render: (data) => data ? 'Active' : 'Inactive' },
                { data: 'created_date', name: 'created_date' },
                { data: 'updated_date', name: 'updated_date' },
                { data: 'edit', orderable: false, searchable: false },
                { data: 'delete', orderable: false, searchable: false },
            ],
        });

        // Filter Action
        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });

        // Edit State
        $('#state-table').on('click', '.editState', function () {
            const id = $(this).data('id');
            $.get(`/stateList/${id}/edit`, function (data) {
                $('#editId').val(data.id);
                $('#editName').val(data.name);
                $('#editStatus').val(data.is_active);
                $('#editModal').modal('show');
            });
        });

        $('#editForm').on('submit', function (e) {
            e.preventDefault();
            const id = $('#editId').val();
            const data = {
                name: $('#editName').val(),
                is_active: $('#editStatus').val(),
            };

            $.ajax({
                url: `/admin/stateList/${id}`,
                type: 'PUT',
                data: data,
                success: function (response) {
                    $('#editModal').modal('hide');
                    table.ajax.reload();
                    alert(response.success);
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Delete State
        $('#state-table').on('click', '.deleteState', function () {
            if (confirm('Are you sure you want to delete this state?')) {
                const id = $(this).data('id');
                $.ajax({
                    url: `/admin/stateList/${id}`,
                    type: 'DELETE',
                    success: function (response) {
                        table.ajax.reload();
                        alert(response.success);
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            }
        });
    });
</script>
@endsection
