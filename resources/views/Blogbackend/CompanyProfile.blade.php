@extends('Blogbackend.components.layout')
@section('title', 'Company')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
<link rel="stylesheet" href="{{ asset('css/company.css') }}">
<div class="container mt-4">
    <div class="addnews">
        <h2>Company List</h2>
        <div>
            <a href="{{route('Dashboardfront')}}" class="btn btn-primary me-2">View Site</a>
            <a href="{{ route('AddCompany') }}" class="btn btn-success">Add Company</a>
        </div>
    </div>
   

    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <div class="table-responsive">
        <table id="user-table" class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Created At</th>
                    <th>Address</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Address Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="address-form">
                    <input type="hidden" id="company_id" name="company_id">
                    <div id="form-fields-container">
                        <!-- Form rows will be populated here -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="add-row-btn" class="btn btn-secondary">Add Row</button>
                <button type="button" id="save-address" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                url: '/getcomAjax',
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
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'type', name: 'type' },
                { data: 'created_at', name: 'created_at' },
                { data: 'address', name: 'address' },
                { data: 'edit', orderable: false, searchable: false },
                { data: 'delete', orderable: false, searchable: false },
            ]
        });

        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });

        $('#user-table').on('click', '.view-address-btn', function () {
            var companyid = $(this).data('company-id');
            $('#save-address').data('company-id', companyid);
            $('#addressModal').modal('show');
            $.ajax({
                url: '/getAddressData',
                type: 'POST',
                data: { company_id: companyid },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        const addressData = response.data;
                        $('#address-form').empty();

                        if (addressData.length > 0) {
                            addressData.forEach(function (address) {
                                const newRow = `
                                    <div class="form-row" data-id="${address.id}">
                                        <input type="hidden" name="id[]" value="${address.id}">
                                        <label for="Address">Address:</label>
                                        <input type="text" name="Address[]" value="${address.address}" required>
                                        <label for="Latitude">Latitude:</label>
                                        <input type="text" name="Latitude[]" value="${address.latitude}">
                                        <label for="Longitude">Longitude:</label>
                                        <input type="text" name="Longitude[]" value="${address.longitude}" required>
                                        <label for="Mobile">Mobile:</label>
                                        <input type="text" name="Mobile[]" value="${address.mobile}" required>
                                        <button type="button" class="delete-address-btn">Delete</button>
                                    </div>
                                `;
                                $('#address-form').append(newRow);
                            });
                        } else {
                            const newRow = `
                                <div class="form-row" data-id="">
                                    <input type="hidden" name="id[]">
                                    <label for="Address">Address:</label>
                                    <input type="text" name="Address[]" value="" required>
                                    <label for="Latitude">Latitude:</label>
                                    <input type="text" name="Latitude[]" value="">
                                    <label for="Longitude">Longitude:</label>
                                    <input type="text" name="Longitude[]" value="" required>
                                    <label for="Mobile">Mobile:</label>
                                    <input type="text" name="Mobile[]" value="" required>
                                    <button type="button" class="delete-address-btn">Delete</button>
                                </div>
                            `;
                            $('#address-form').append(newRow);
                        }
                    } else {
                        alert('Failed to fetch address data');
                    }
                },
                error: function () {
                    alert('An error occurred while fetching the address data');
                }
            });
        });

        $('#add-row-btn').on('click', function () {
            const newRow = `
                <div class="form-row">
                    <input type="hidden" name="id[]">
                    <label for="Address">Address:</label>
                    <input type="text" name="Address[]" required>
                    <label for="Latitude">Latitude:</label>
                    <input type="text" name="Latitude[]">
                    <label for="Longitude">Longitude:</label>
                    <input type="text" name="Longitude[]" required>
                    <label for="Mobile">Mobile:</label>
                    <input type="text" name="Mobile[]" required>
                    <button type="button" class="delete-address-btn">Delete</button>
                </div>`;
            $('#address-form').append(newRow);
        });

        $('#save-address').on('click', function () {
            var companyid = $(this).data('company-id');
            var formData = $('#address-form').serializeArray();  

            var data = {};
            formData.forEach(function (item) {
                if (!data[item.name]) {
                    data[item.name] = [];
                }
                data[item.name].push(item.value);
            });

            data.company_id = companyid;
            $.ajax({
                url: '/saveCompanyAddress',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Data saved successfully!');
                        $('#addressModal').modal('hide');
                        table.ajax.reload();
                    } else {
                        alert(response.message || 'Failed to save data');
                    }
                },
                error: function () {
                    alert('An error occurred while saving the data');
                }
            });
        });

        $('#address-form').on('click', '.delete-address-btn', function () {
            var row = $(this).closest('.form-row'); 
            var addressId = row.find('input[name="id[]"]').val(); 

            if (confirm("Are you sure you want to delete this address?")) {
                $.ajax({
                    url: '/deleteAddress', 
                    type: 'POST',
                    data: { id: addressId },
                    success: function (response) {
                        if (response.status === 'success') {
                            row.remove(); 
                        } else {
                            alert(response.message || 'Failed to delete the address');
                        }
                    },
                    error: function () {
                        alert('An error occurred while deleting the address');
                    }
                });
            }
        });
    });
</script>
@endsection
