@extends('Blogbackend.components.layout')
@section('title', 'Blogs')
@section('content')
<link rel="stylesheet" href='{{ asset('css/blog.css') }}'>
<style>
    svg {
        width: 16px;
        height: 16px;
        vertical-align: middle;
    }

    .pagination-container {
        margin-top: 30px;
        text-align: center;
    }

    .pagination-container .pagination {
        display: inline-block;
        list-style: none;
        padding: 0;
    }

    #search {
        padding: 6px;
        border: none;
        border-radius: 5px;
    }

    .scol {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .pagination-container .pagination li {
        display: inline;
        margin: 0 8px;
    }

    .search {
        display: flex;
        flex-direction: row;
        gap: 10px;
    }

    .pagination-container .pagination a,
    .pagination-container .pagination span {
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    p {
        margin-top: 10px;
    }

    .pagination-container .pagination a:hover,
    .pagination-container .pagination .active {
        background-color: #0056b3;
    }

    .pagination-container .pagination .disabled a {
        background-color: #f4f4f4;
        color: #ccc;
    }

    .search-input-container {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .search-input-container input {
        flex-grow: 1;
        padding: 6px;
        border: none !important;
        border-radius: 5px 0 0 5px;
    }

    .search-input-container button {
        padding: 6px 12px;
        background-color: #007bff;
        color: white;
        border: none !important;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .search-input-container button:hover {
        background-color: #0056b3;
    }
</style>

<div class="container mt-4">
    <div class="addnews">
        <h2>Blogs List</h2>
        <div>
            <a href="{{ route('Dashboardfront') }}" class="btn btn-primary me-2">View Site</a>
            <a href="{{ route('addblog') }}" class="btn btn-success">Add Blog</a>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="table-responsive">
        <form method="GET" action="{{ route('BlogList') }}">
            <div class="filter-container">
                <h4>Filter</h4>
                <div class="filter">
                    <label for="startDate">Start Date:</label>
                    <input type="date" name="startDate" id="startDate" value="{{ request()->startDate }}">
                    <label for="endDate">End Date:</label>
                    <input type="date" name="endDate" id="endDate" value="{{ request()->endDate }}">
                </div>
                <div class="search">
                    <label for="search">Search:</label>
                    <div class="scol">
                        <select name="search" id="search">
                            <option value="" disabled {{ request()->search == '' ? 'selected' : '' }}>Search By</option>
                            <option value="Category" {{ request()->search == 'Category' ? 'selected' : '' }}>Category</option>
                            <option value="Title" {{ request()->search == 'Title' ? 'selected' : '' }}>Title</option>
                        </select>
                        <div class="search-input-container">
                            <input type="text" name="searchValue" id="searchValue" value="{{ request()->searchValue }}" placeholder="Enter search value">
                            <button type="submit" id="filterButton" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <table id="user-table" class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Title</th>
                    <th>Author Name</th>
                    <th>Category</th>
                    <th>Domain</th>
                    <th>Language</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userdata as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user_id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->authorname }}</td>
                    <td>{{ $item->categories->categorytitle }}</td>
                    <td>{{ $item->domainrel ? $item->domainrel->domainname : 'N/A' }}</td>
                    <td>{{ $item->langrel ? $item->langrel->languages : 'N/A' }}</td>
                    <td>
                        <div style="display: flex; flex-direction: row;">
                            <select name="approvalLevel" class="approval-select" data-id="{{ $item->id }}" dis>
                                @foreach ($designations->take($item->approval->designation_id) as $designation)
                                    <option value="{{ $designation->id }}" {{ $item->approval->approval == $designation->id ? 'selected' : '' }} disabled>
                                        Approved by {{ $designation->designation_name }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-success approve-btn" data-id="{{ $item->id }}" 
                                @if ($item->approval->designation_id > $designationid) disabled @endif>
                                Approve
                            </button>
                        </div>
                    </td>
                    
                    <td>{{ $item->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('EditBlog', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                    </td>
                    <td>
                        <a href="{{ route('DeleteBlog', $item->id) }}" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="pagination-container">
            {{ $userdata->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        
        // Approve button click event
        $(document).on('click', '.approve-btn', function () {
            var blogid = $(this).data('id');
            var designationId =  {{$designationid}} // Get selected designation ID
            var userid = "{{ session('user_id') }}"; // Get current user ID from session

            $.ajax({
                url: '/statusAjax', // Your endpoint for handling the status update
                type: 'POST',
                data: {
                    blogid: blogid,
                    designationid: designationId, // Pass the selected designation ID
                    userid: userid,
                    approvalLevel: designationId, // Pass the selected designation ID
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        alert('Status updated successfully!');
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