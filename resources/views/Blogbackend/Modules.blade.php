@extends('Blogbackend.components.layout')

@section('title', 'Blogs')

@section('content')
<style>
    /* Modal Styling */
#modal {
    display: none; /* Ensure modal is hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Darker background for better contrast */
    z-index: 9999; /* Ensures the modal is on top */
    /* display: flex; */
    align-items: center; /* Center vertically */
    justify-content: center; /* Center horizontally */
    transition: opacity 0.3s ease;
    flex-direction: column; /* Stack items vertically */
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

</style>

<div class="container mt-4">
    <div class="addnews">
        <h2>Modules List</h2>
        <div>
            <a href="{{ route('Dashboardfront') }}" class="btn btn-primary me-2">View Site</a>
            <a href="{{ route('addmodule') }}" class="btn btn-success">Add Module</a>
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
                    <th>Permissions</th>
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

<!-- Modal Structure -->
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
        
        <!-- Buttons inside modal -->
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
    // Setup CSRF token for AJAX requests
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
            url: '/getmoduleAjax',
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
            { data: 'modulesname', name: 'modulesname' },
            { data: 'parent_id', name: 'parent_id' },
            { data: 'permissions', name: 'permissions' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'created_at', name: 'created_at' },
            { data: 'addpermissions', orderable: false, searchable: false },
            { data: 'edit', orderable: false, searchable: false },
            { data: 'delete', orderable: false, searchable: false },
        ],
    });

    // Filter button functionality
    $('#filterButton').on('click', function () {
        table.ajax.reload();
    });

   
    $('#user-table').on('click', '#permissionsbtn', function () {
        var moduleid = $(this).data('module-id');
        $('#savePermissions').data('module-id', moduleid);
        $('#modal').css('display', 'flex').hide().fadeIn(300);  
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

      
        $('.input-container input').each(function () {
            const permission = $(this).val().trim();
            if (permission) {
                permissions.push(permission);
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
            url: '{{ route('savePermissions') }}', 
            type: 'POST',
            data: {
                permissions: permissions,
                module_id: moduleId,
                guard_name: guardName,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response); 
                if (response.success) {
                    alert('Permissions saved successfully!');
                    $('#modal').fadeOut(); 
                } else {
                    alert('There was an error saving the permissions.');
                }
            },
            error: function (error) {
                console.error('Error saving permissions:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });
});

</script>

@endsection
