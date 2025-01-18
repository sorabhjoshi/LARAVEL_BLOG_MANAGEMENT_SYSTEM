@extends('Blogbackend.components.layout')
@section('title', 'News')
@section('content')
<link rel="stylesheet" href='{{ asset('css/blog.css') }}'>

<style>
     #search {
        padding: 6px;
        border: none;
        border-radius: 5px;
    }.status-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}

.approval-select {
    width: 100%;
    padding: 6px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    font-size: 14px;
}

.status-actions {
    display: flex;
    gap: 5px;
}

.status-actions .btn {
    display: flex;
    flex-direction: row;
    padding: 6px 10px;
    justify-content: center;
    align-content: center;
    text-align: center;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.status-actions .btn-success:hover {
    background-color: #28a745;
    color: white;
}

.status-actions .btn-danger:hover {
    background-color: #dc3545;
    color: white;
}
</style>
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
                { data: 'user_id', name: 'user_id' },
                { data: 'title', name: 'title' },
                { data: 'authorname', name: 'authorname' },
                { data: 'category', name: 'category' },
                { data: 'domain', name: 'domain' },
                { data: 'language', name: 'language' },
                { data: 'status',name: 'status'},
                { data: 'created_at', name: 'created_at' },
                { data: 'edit', orderable: false, searchable: false },
                { data: 'delete', orderable: false, searchable: false },
            ],
        });

        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });

        $(document).on('click', '.approve-btn', function () {
            var newsid = $(this).data('id');
            var designationId =  {{$designationid}} // Get selected designation ID
            var userid = "{{ session('user_id') }}"; // Get current user ID from session

            $.ajax({
                url: '/statusnewsAjax', // Your endpoint for handling the status update
                type: 'POST',
                data: {
                    newsid: newsid,
                    designationid: designationId, // Pass the selected designation ID
                    userid: userid,
                    approvalLevel: designationId, // Pass the selected designation ID
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        alert('Status updated successfully!');
                        table.ajax.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Error changing status');
                }
            });
        });

        $(document).on('click', '.reject-btn', function () {
            var newsid = $(this).data('id');
            var designationId =  {{$designationid}} // Get selected designation ID
            var userid = "{{ session('user_id') }}"; // Get current user ID from session

            $.ajax({
                url: '/newsstatusrejectAjax', // Your endpoint for handling the status update
                type: 'POST',
                data: {
                    newsid: newsid,
                    designationid: designationId, // Pass the selected designation ID
                    userid: userid,
                    approvalLevel: designationId, // Pass the selected designation ID
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        alert('Approval Rejected successfully!');
                        table.ajax.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Error changing status');
                }
            });
        });
    });
</script>
@endsection
