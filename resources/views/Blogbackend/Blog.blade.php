@extends('Blogbackend.components.layout')
@section('title', 'Blogs')
@section('content')
<link rel="stylesheet" href='{{asset('css/blog.css')}}'>
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
    p{
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
</style>
<div class="container mt-4">
    <div class="addnews">
        <h2>Blogs List</h2>
        <div>
           
            <a href="{{route('Dashboardfront')}}" class="btn btn-primary me-2">View Site</a>
            <a href="{{ route('addblog') }}" class="btn btn-success">Add Blog</a>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="table-responsive">
        <table id="user-table" class="user-table">
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
                        <select name="search" id="search">
                            <option value="" disabled {{ request()->search == '' ? 'selected' : '' }}>Search By</option>
                            <option value="Category" {{ request()->search == 'Category' ? 'selected' : '' }}>Category</option>
                            <option value="Title" {{ request()->search == 'Title' ? 'selected' : '' }}>Title</option>
                        </select>
                        <input type="text" name="searchValue" id="searchValue" value="{{ request()->searchValue }}">
                    </div>
                    <button type="submit" id="filterButton">Filter</button>
                </div>
            </form>
        
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Title</th>
                    <th>Author Name</th>
                    <th>Category</th>
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
                    <td>{{ $item->categories->categorytitle}}</td>
                    <td>{{ $item->created_at }}</td>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

{{-- <script>
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
                url: '/getblogAjax',
                type: 'POST',
                data: function (d) {
                    d.startDate = $('#startDate').val(); 
                   d.endDate = $('#endDate').val(); 
                } 
            },
            pageLength: 5, 
            columns: [
                {
                    data: null, // This column is for the auto-incrementing number
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1 + meta.settings._iDisplayStart; // Calculate row number
                    }
                },
                { data: 'slug', name: 'slug' },
                { data: 'user_id', name: 'user_id' },
                { data: 'title', name: 'title' },
                { data: 'authorname', name: 'authorname' },
                { data: 'category', name: 'category' },
                { data: 'created_at', name: 'created_at' },
                { data: 'edit', orderable: false, searchable: false },
                { data: 'delete', orderable: false, searchable: false },
            ],
        });
        $('#filterButton').on('click', function () {
            table.ajax.reload();
        });
    });
</script> --}}
@endsection