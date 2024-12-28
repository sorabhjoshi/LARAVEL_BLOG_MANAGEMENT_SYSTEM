@extends('Blogbackend.components.layout')
@section('title', 'Blog Category')
@section('content')
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
    #search{
        padding: 6px;
        border: none;
        border-radius: 5px;
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
</style>
<link rel="stylesheet" href='{{ asset('css/blog.css') }}'>
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
                <label for="startDate">Start Date:</label>
                <input type="date" name="startDate" id="startDate" value="{{ request()->startDate }}">
                <label for="endDate">End Date:</label>
                <input type="date" name="endDate" id="endDate" value="{{ request()->endDate }}">
               
            </div>
            <div class="search">
                <label for="search">Search:</label>
                <select name="search" id="search">
                    <option value="" disabled {{ request()->search == '' ? 'selected' : '' }}>Search By</option>
                    <option value="Category" {{ request()->search == 'Category' ? 'selected' : '' }}>Category</option>
                    <option value="Name" {{ request()->search == 'Name' ? 'selected' : '' }}>Name</option>
                </select>
                <input type="text" name="searchValue" id="searchValue" value="{{ request()->searchValue }}">
            </div>
            <button type="submit" id="filterButton">Filter</button>
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
                <th>Edit</th>
                <th>Delete</th>
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
                <td>{{ $item->created_at->diffForHumans(); }}</td>
                <td>
                    <a href="{{ route('EditBlogCat', $item->id) }}" class="btn btn-warning">Edit</a>
                </td>
                <td>
                    <a href="{{ route('DeleteBlogCat', $item->id) }}" class="btn btn-danger">Delete</a>
                </td>
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
