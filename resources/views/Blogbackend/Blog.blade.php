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
        padding: 12px;
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
        flex-direction: row;
        align-items: center;
        gap: 5px;
    }

    .search-input-container input {
        margin-top: 15px;
        flex-grow: 1;
        padding: 15px;
        border: none !important;
        border-radius: 5px 0 0 5px;
    }

    .search-input-container button {
        padding: 6px 12px;
        margin-top: 15px;

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
    .status-container {
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
    padding: 6px 10px;
    font-size: 17px;
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
.filter-container {
    background-color: #587ba1;  /* Blue background */
    color: white;  /* Text color for contrast */
    border-radius: 8px 8px 0 0;  /* Rounded top corners */
    padding: 15px 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.filter-container h4 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.filter-container .filter,
.filter-container .search {
    display: flex
;
    gap: 15px;
    align-items: center; /* Align items in a row */
}

.filter-container .filter label,
.filter-container .search label {
    font-size: 1rem;
    font-weight: 500;
    color: white;
}
.form-group{
    display: flex;
    flex-direction: column;
}
.filter-container .filter input,
.filter-container .search select,
.filter-container .search input {
    padding: 8px 12px;
    border-radius: 5px;
    border: none;
    font-size: 1rem;
    width: 200px;  /* All inputs have the same width */
}

.filter-container .filter input:focus,
.filter-container .search select:focus,
.filter-container .search input:focus {
    border-color: #587ba1;
    outline: none;
}

.filter-container .search button {
    padding: 8px 12px;
    background-color: #587ba1;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.filter-container .search button:hover {
    background-color: #587ba1;
}

.filter-container .search button i {
    font-size: 16px; /* Adjust the icon size */
    margin-right: 8px;  /* Add space between icon and text */
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
            <div class="filter-container">
                <h4>Filter</h4>
                <form method="GET" action="{{ route('BlogList') }}">
                    <div class="filter">
                        <div class="form-group">
                            <label for="startDate">Start Date:</label>
                            <input type="date" name="startDate" id="startDate" value="{{ request()->startDate }}">
                        </div>
                        <div class="form-group">
                            <label for="endDate">End Date:</label>
                            <input type="date" name="endDate" id="endDate" value="{{ request()->endDate }}">
                        </div>
                        <div class="search">
                            <div class="form-group">
                                <label for="search">Search By:</label>
                                <select name="search" id="search">
                                    <option value="" disabled {{ request()->search == '' ? 'selected' : '' }}>Select Search Criteria</option>
                                    <option value="Category" {{ request()->search == 'Category' ? 'selected' : '' }}>Category</option>
                                    <option value="Title" {{ request()->search == 'Title' ? 'selected' : '' }}>Title</option>
                                </select>
                            </div>
                            <div class="search-input-container">
                                <input type="text" name="searchValue" id="searchValue" value="{{ request()->searchValue }}" placeholder="Enter search value">
                                <button type="submit" id="filterButton" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            

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
                        <div class="status-container">
                            <select name="approvalLevel" class="approval-select" data-id="{{ $item->id }}" dis>
                                @foreach ($designations->take($item->approval->designation_id) as $designation)
                                    <option value="{{ $designation->id }}" {{ $item->approval->designation_id == $designation->id ? 'selected' : '' }} disabled>
                                        Approved by {{ $designation->designation_name }} 
                                    </option>
                                @endforeach
                            </select>
                            <div class="status-actions">
                                <button class="btn btn-success approve-btn" data-id="{{ $item->id }}" 
                                    @if ($item->approval->designation_id > $designationid) disabled @endif>
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button class="btn btn-danger reject-btn" data-id="{{ $item->id }}" 
                                    @if ($item->approval->designation_id > $designationid) disabled @endif>
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </div>
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

        $(document).on('click', '.reject-btn', function () {
            var blogid = $(this).data('id');
            var designationId =  {{$designationid}} // Get selected designation ID
            var userid = "{{ session('user_id') }}"; // Get current user ID from session

            $.ajax({
                url: '/statusrejectAjax', // Your endpoint for handling the status update
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
                        alert('Approval Rejected successfully!');
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