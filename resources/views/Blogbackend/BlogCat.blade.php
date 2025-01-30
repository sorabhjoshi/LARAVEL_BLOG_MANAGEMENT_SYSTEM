@extends('Blogbackend.components.layout')
@section('title', 'Blog Category')
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

    .pagination-container .pagination li {
        display: inline;
        margin: 0 8px;
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

    .pagination-container .pagination a:hover,
    .pagination-container .pagination .active {
        background-color: #0056b3;
    }

    .pagination-container .pagination .disabled a {
        background-color: #f4f4f4;
        color: #ccc;
    }
    .filter-container {
    background-color: #587ba1 !important;  /* Blue background */
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
    display: flex;
    gap: 15px;
    align-items: center;  /* Align items in a row */
}

.filter-container .filter label,
.filter-container .search label {
    font-size: 1rem;
    font-weight: 500;
    color: white;
}

.filter-container .filter input,
.filter-container .search select,
.filter-container .search input {
    padding: 8px 12px;
    border-radius: 5px;
    border: none;
    font-size: 1rem;
    width: 200px;/* All inputs have the same width */
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
.form-group{
    display: flex;
    flex-direction: column;
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
    #search {
    padding: 10px;
    border: none;
    border-radius: 5px;
}
</style>

<div class="container mt-4">
    <div class="addnews">
        <h2>Blogs Category List</h2>
        <div>
            <a href="{{ route('Dashboardfront') }}" class="btn btn-primary me-2">View Site</a>
            <a href="{{ route('AddBlogCat') }}" class="btn btn-success">Add Blog Category</a>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Filter Form -->
    <form method="GET" action="{{ route('BlogCategoryList') }}">
        <div class="filter-container">
            <h4>Filter</h4>
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
        </div>
    </form>

    <!-- Table of Blog Categories -->
    <table id="user-table" class="user-table">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Category Title</th>
                <th>Seo Title</th>
                <th>Meta Keywords</th>
                <th>Meta Description</th>
                <th>Created At</th>
                @can('blogcat-edit')
                <th>Edit</th>
                @endcan
                @can('blogcat-delete')
                <th>Delete</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($userdata as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->categorytitle .' - '. $item->blogs_count }}</td>
                <td>{{ $item->seotitle }}</td>
                <td>{{ $item->metakeywords }}</td>
                <td>{{ $item->metadescription }}</td>
                <td>{{ $item->created_at->diffForHumans() }}</td>
                @can('blogcat-edit')
                <td>
                    <a href="{{ route('EditBlogCat', $item->id) }}" class="btn btn-warning">Edit</a>
                </td>
                @endcan
                @can('blogcat-delete')
                <td>
                    <a href="{{ route('DeleteBlogCat', $item->id) }}" class="btn btn-danger">Delete</a>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination-container">
        {{ $userdata->appends(request()->query())->links() }}
    </div>
</div>

@endsection
