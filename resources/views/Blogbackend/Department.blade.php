@extends('Blogbackend.components.layout')
@section('title', 'Department')
<style>/* The overlay background */
    .overlay-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: none; /* Initially hidden */
        justify-content: center;
        align-items: center;
        display: flex;
    }
    
    /* The modal content */
    .overlay-content {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 400px; /* Adjust width as needed */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Close button styling */
    #closeModalBtn {
        background-color: #6c757d;
        border: none;
        color: white;
    }
    </style>
@section('content')
<link rel="stylesheet" href='{{asset('css/blog.css')}}'>
<div class="container mt-4">
    <div class="addnews">
        <h2>Department List</h2>
        <div>
            <a href="{{route('Dashboardfront')}}" class="btn btn-primary me-2">View Site</a>
            <button id="addDepartmentBtn" class="btn btn-success">Add Department</button>
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
                <th>Department</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Overlay Modal -->
<div id="addDepartmentModal" class="overlay-modal" style="display: none;">
    <div class="overlay-content">
        <h3>Add Department</h3>
        <form id="addDepartmentForm">
            <div class="form-group">
                <label for="departmentName">Department Name:</label>
                <input type="text" id="departmentName" name="departmentName" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
            <button type="button" id="closeModalBtn" class="btn btn-secondary mt-2">Cancel</button>
        </form>
    </div>
</div>




@endsection

@section('js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        // CSRF Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize DataTable
        const table = $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/GetDepartmentAjax',
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
                { data: 'department_name', name: 'department_name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'edit', orderable: false, searchable: false },
                { data: 'delete', orderable: false, searchable: false },
            ],
        });

        // Filter Button
        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });

        // Show Add Department Modal
        $('#addDepartmentBtn').on('click', function () {
            $('#addDepartmentModal').fadeIn();
        });

        // Hide Add Department Modal
        $('#closeModalBtn').on('click', function () {
            $('#addDepartmentModal').fadeOut();
        });

        // Handle Add Department Form Submission
        $('#addDepartmentForm').on('submit', function (e) {
            e.preventDefault();
            const departmentName = $('#departmentName').val();

            $.ajax({
                url: '/AddDepartmentAjax',
                method: 'POST',
                data: { department_name: departmentName },
                success: function (response) {
                    if (response.success) {
                        $('#addDepartmentModal').fadeOut();
                        $('#addDepartmentForm')[0].reset();
                        table.ajax.reload();
                        alert('Department added successfully!');
                    } else {
                        alert('Failed to add department. Please try again.');
                    }
                },
                error: function () {
                    alert('An error occurred while adding the department.');
                }
            });
        });
    });
</script>
@endsection
