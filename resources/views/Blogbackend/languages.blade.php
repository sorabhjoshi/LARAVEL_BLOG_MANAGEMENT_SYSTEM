@extends('Blogbackend.components.layout')
@section('title', 'Languages')
@section('content')
<link rel="stylesheet" href='{{ asset('css/blog.css') }}'>

<div class="container mt-4">
    <div class="addnews">
        <h2>Languages List</h2>
        <div>
            <a href="{{ route('Dashboardfront') }}" class="btn btn-primary me-2">View Site</a>
            <button id="addLanguageButton" class="btn btn-success">Add Language</button>
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
                <th>Languages</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="languageModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Language</h2>
        <form id="addLanguageForm">
            <label for="languageName">Language Name:</label>
            <input type="text" id="languageName" name="languageName" required>
            <button type="submit" class="btn btn-primary mt-2">Save Language</button>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editLanguageModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Language</h2>
        <form id="editLanguageForm">
            <input type="hidden" id="editLanguageId">
            <label for="editLanguageName">Language Name:</label>
            <input type="text" id="editLanguageName" name="editLanguageName" required>
            <button type="submit" class="btn btn-primary mt-2">Save Changes</button>
        </form>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 60%;
        transform: translate(-50%, -50%);
        width: 400px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 20px;
        z-index: 1000;
        height: 400px;
    }

    .modal-content {
        position: relative;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        cursor: pointer;
        font-size: 20px;
        color: #aaa;
    }

    .close:hover {
        color: #000;
    }
</style>

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
                url: '/getlanguagesAjax',
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
                { data: 'languages', name: 'languages' },
                { data: 'created_at', name: 'created_at' },
                {
                    data: 'edit',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `<button class="btn btn-warning edit-button" data-id="${row.id}" data-name="${row.languages}">Edit</button>`;
                    }
                },
                {
                    data: 'delete',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `<button class="btn btn-danger delete-button" data-id="${row.id}">Delete</button>`;
                    }
                },
            ],
        });

        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });

        const addModal = $('#languageModal');
        const editModal = $('#editLanguageModal');
        const closeButtons = $('.close');

        // Open Add Modal
        $('#addLanguageButton').on('click', function () {
            addModal.show();
        });

        // Open Edit Modal
        $(document).on('click', '.edit-button', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#editLanguageId').val(id);
            $('#editLanguageName').val(name);
            editModal.show();
        });

        // Close Modals
        closeButtons.on('click', function () {
            addModal.hide();
            editModal.hide();
        });

        // Save New Language
        $('#addLanguageForm').on('submit', function (e) {
            e.preventDefault();
            const languageName = $('#languageName').val();

            $.ajax({
                url: '/addlanguageAjax',
                type: 'POST',
                data: { languageName },
                success: function (response) {
                    alert('Language added successfully!');
                    addModal.hide();
                    table.ajax.reload();
                },
                error: function () {
                    alert('Error adding language.');
                }
            });
        });

        // Save Edited Language
        $('#editLanguageForm').on('submit', function (e) {
            e.preventDefault();
            const id = $('#editLanguageId').val();
            const languageName = $('#editLanguageName').val();

            $.ajax({
                url: `/editlanguageAjax/${id}`,
                type: 'PUT',
                data: { languageName },
                success: function (response) {
                    alert('Language updated successfully!');
                    editModal.hide();
                    table.ajax.reload();
                },
                error: function () {
                    alert('Error updating language.');
                }
            });
        });

        // Delete Language
        $(document).on('click', '.delete-button', function () {
            const id = $(this).data('id');

            if (confirm('Are you sure you want to delete this language?')) {
                $.ajax({
                    url: `/deletelanguageAjax/${id}`,
                    type: 'DELETE',
                    success: function (response) {
                        alert('Language deleted successfully!');
                        table.ajax.reload();
                    },
                    error: function () {
                        alert('Error deleting language.');
                    }
                });
            }
        });
    });
</script>
@endsection
