@extends('Blogbackend.components.layout')

@section('title', 'Modules')

@section('content')
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
        <h2>Modules List</h2>
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
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Add Permissions</th>
                    <th>Edit</th>
                    <th>Delete</th>
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
                url: '/getmoduleAjax',
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
                { data: 'updated_at', name: 'updated_at' },
                { data: 'created_at', name: 'created_at' },
                { data: 'addpermissions', orderable: false, searchable: false },
                { data: 'edit', orderable: false, searchable: false },
                { data: 'delete', orderable: false, searchable: false },
            ],
            lengthMenu: [5, 10, 25, 50], // Options for rows per page
        });

        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });

        $('#user-table').on('click', '#permissionsbtn', function () {
    var moduleid = $(this).data('module-id');
    $('#savePermissions').data('module-id', moduleid);

    $.ajax({
        url: '{{ route('ShowPermissions') }}',
        type: 'POST', 
        data: {
            module_id: moduleid,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            const permissionsContainer = $('.input-container'); 
            permissionsContainer.empty(); // Clear previous content

            if (response.status === 'success' && response.data.length > 0) {
                const permissionsData = response.data;
                permissionsData.forEach(permission => {
                    const newRow = `
                        <div class="input-row">
                            <label>Permission Name</label>
                            <input type="text" value="${permission.name}" data-permission-id="${permission.id}" class="permission-input">
                            <button class="delete-permission btn btn-danger" data-permission-id="${permission.id}">Delete</button>
                        </div>`;
                    permissionsContainer.append(newRow);
                });
            } else {
                // Add a blank input row when no permissions exist
                const newRow = `
                    <div class="input-row">
                        <label>Permission Name</label>
                        <input type="text" value="" class="permission-input">
                    </div>`;
                permissionsContainer.append(newRow);
            }

            $('#modal').css('display', 'flex').hide().fadeIn(300);
        },
        error: function (error) {
            console.error('Error fetching permissions:', error);
            alert('An error occurred. Please try again.');
        }
    });
});


        $('#closeModal').on('click', function () {
            $('#modal').fadeOut(300, function () {
                $('#modal').css('display', 'none');
            });
        });

        $('#AddMore').on('click', function () {
            const newRow = `
                <div class="input-row">
                    <label>Permission Name</label>
                    <input type="text" value="">
                </div>`;
            $('.input-container').append(newRow);  
        });

        $('#savePermissions').on('click', function () {
            var moduleid = $(this).data('module-id');
            let permissions = [];
            let moduleId = moduleid;
            let guardName = 'web';

            $('.input-container .input-row').each(function () {
                const permissionName = $(this).find('input').val().trim();
                const permissionId = $(this).find('input').data('permission-id') || null; 
                if (permissionName) {
                    permissions.push({
                        id: permissionId,
                        name: permissionName
                    });
                }
            });

            if (permissions.length === 0) {
                alert('Please add at least one permission.');
                return;
            }

            console.log({
                permissions: permissions,
                module_id: moduleId,
                guard_name: guardName
            });

            $.ajax({
                url: '/storepermission',
                type: 'POST',
                data: {
                    permissions: permissions,
                    module_id: moduleId,
                    guard_name: guardName,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success === true) {
                        alert('Permissions saved successfully.');
                        $('#modal').fadeOut(300, function () {
                            $('#modal').css('display', 'none');
                        });
                        table.ajax.reload(); 
                    } else {
                        alert('Failed to save permissions.');
                    }
                },
                error: function () {
                    alert('An error occurred while saving permissions.');
                }
            });
        });
        $(document).ready(function () {
    // Existing setup code here...

    // Handle delete functionality for permissions
    $('.input-container').on('click', '.delete-permission', function () {
        const permissionId = $(this).data('permission-id');

        if (!permissionId) {
            alert('This permission has not been saved yet and cannot be deleted.');
            return;
        }

        if (confirm('Are you sure you want to delete this permission?')) {
            $.ajax({
                url: '{{ route('deletePermission') }}', // Backend route to handle permission deletion
                type: 'POST',
                data: {
                    permission_id: permissionId,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.success === true) {
                        alert('Permission deleted successfully.');
                        // Remove the row from the DOM
                        $(`.delete-permission[data-permission-id="${permissionId}"]`).closest('.input-row').remove();
                    } else {
                        alert('Failed to delete permission.');
                    }
                },
                error: function () {
                    alert('An error occurred while deleting the permission.');
                },
            });
        }
    });

    // Existing modal and save functionality code here...
});

    });
</script>
@endsection
