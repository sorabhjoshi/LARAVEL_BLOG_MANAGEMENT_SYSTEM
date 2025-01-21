@extends('Blogbackend.components.layout')

@section('title', 'Modules')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href='{{asset('css/blog.css')}}'>
<style>
#modal {
    display: none; /* Ensure modal is hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); 
    z-index: 9999; 
    align-items: center; 
    justify-content: center; 
    transition: opacity 0.3s ease;
    flex-direction: column; 
}

/* Modal Content */
.modal-content {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    width: 500px;
    max-width: 90%;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    position: relative;
    animation: slideUp 0.3s ease-out;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    max-height: 80vh;
    overflow-y: auto;
}

/* Modal Animation */
@keyframes slideUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Close Button as Icon */
#closeModal {
    background-color: transparent;
    color: #007bff;
    border: none;
    font-size: 30px;
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

#closeModal:hover {
    color: #0056b3;
}

/* Buttons Container */
.modal-buttons-container {
    width: 100%;
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.modal-buttons-container .btn {
    width: 48%; /* Buttons will take up half of the container */
}
.input-row label{
    margin-bottom: 10px;
}


</style>

<div class="container mt-4">
    <div class="addnews">
        <h2>Deleted Modules List</h2>
        <div>
            <a href="{{ route('Dashboardfront') }}" class="btn btn-primary me-2">View Site</a>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="table-responsive">
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
                    <th>Module Name</th>
                    <th>Parent ID</th>
                    <th>Recover</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="modal" class="modal">
    <div class="modal-content">
        <button id="closeModal">&times;</button>
        <h4 style="border-bottom: #0056b3 solid 3px">Add Permissions</h4>
        <div class="input-container">
            <div class="input-row">
                <label>Permission Name</label>
                <input type="text" value="">
            </div>
        </div>
        
        <div class="modal-buttons-container">
            <button id="AddMore" class="btn btn-primary">Add More</button>
            <button id="savePermissions" class="btn btn-success">Save</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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
            paging: true, // Enable pagination
            ordering: true, // Enable ordering
            ajax: {
                url: '/getmodulerecoverAjax',
                type: 'POST',
                data: function (d) {
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                    d.start = d.start;
                    d.length = d.length;
                },
                dataSrc: function (json) {
                    return json.data; // Ensure the correct data is returned
                }
            },
            pageLength: 5, // Adjust the number of rows per page if needed
            order: [[1, 'asc']], // Default ordering: column 1 (Module Name) in ascending order
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1 + meta.settings._iDisplayStart;
                    }
                },
                { data: 'modulesname', name: 'modulesname' },
                { data: 'parent_id', name: 'parent_id' },
                { data: 'recover', orderable: false, searchable: false },
            ],
            lengthMenu: [5, 10, 25, 50], // Options for rows per page
        });

        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });
      
    

    });
</script>

@endsection
