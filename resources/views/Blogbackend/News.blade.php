@extends('Blogbackend.components.layout')
@section('title', 'News')
@section('content')
<style>
     #search {
        padding: 6px;
        border: none;
        border-radius: 5px;
    }
</style>
<link rel="stylesheet" href='{{ asset('css/blog.css') }}'>
<div class="container mt-4">
    <div class="addnews">
        <h2>News List</h2>
        <div>
            <a href="{{ route('Dashboardfront') }}" class="btn btn-primary me-2">View Site</a>
            <a href="{{ route('AddNews') }}" class="btn btn-success">Add News</a>
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
                <th>Slug</th>
                <th>User ID</th>
                <th>Title</th>
                <th>City</th>
                <th>Category</th>
                <th>Domain</th>
                <th>Language</th>
                <th>Status</th>
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
                url: '/getnewsAjax',
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
                { data: 'slug', name: 'slug' },
                { data: 'user_id', name: 'user_id' },
                { data: 'title', name: 'title' },
                { data: 'authorname', name: 'authorname' },
                { data: 'category', name: 'category' },
                { data: 'domain', name: 'domain' },
                { data: 'language', name: 'language' },
                {
    data: 'status',
    orderable: false,
    searchable: false,
    render: function (data, type, row) {
        var designation = {{ $designation }};
        if (designation == 6) {
            let statusOptions = {!! json_encode($statuses->pluck('status', 'id')) !!};
            let optionsHtml = '';
            for (let id in statusOptions) {
                let selected = ( row.statuss?.id == id) ? 'selected' : '';
                optionsHtml += `<option value="${id}" ${selected}>${statusOptions[id]}</option>`;
            }
            return `<select class="status-dropdown" id='search'>${optionsHtml}</select>`;
        } else {
            return row.statuss ? row.statuss.status : 'N/A';
        }
    }
}

,
                { data: 'created_at', name: 'created_at' },
                { data: 'edit', orderable: false, searchable: false },
                { data: 'delete', orderable: false, searchable: false },
            ],
        });

        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });

        $('#user-table').on('change', '.status-dropdown', function() {
            var statusId = $(this).val();
            var rowId = $(this).closest('tr').find('td:first').text();

            $.ajax({
                url: '/update-news-status',
                method: 'POST',
                data: {
                    id: rowId,
                    status: statusId,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.success) {
                        alert('Status updated successfully');
                    } else {
                        alert('Failed to update status');
                    }
                }
            });
        });
    });
</script>
@endsection
