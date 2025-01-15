@extends('Blogbackend.components.layout')
@section('title', 'Users')
@section('content')
<style>
    
@media (max-width: 768px) {
    .content {
    padding: 30px 20px 0 30px;
    flex-grow: 1;
}
.links{
    display:flex; 
    flex-direction: column; 
    gap: 10px ;
}

}
</style>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Create New User</a>
        </div>
    </div>
</div>

@session('success')
    <div class="alert alert-success" role="alert"> 
        {{ $value }}
    </div>
@endsession

<table class="table table-bordered">
   <tr>
       <th>No</th>
       <th>Name</th>
       <th>Email</th>
       <th>Department</th>
       <th>Designation</th>
       <th>Roles</th>
       <th width="280px">Action</th>
   </tr>
   @foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
          @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
               <label class="badge bg-success">{{ $v }}</label>
            @endforeach
          @endif
        </td>
        <td>{{ $user->departments->department_name ?? 'N/A' }}</td>
        <td>{{ $user->Designations->designation_name ?? 'N/A' }}</td>
        <td>
            <div class="links">
                <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                 <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                     @csrf
                     @method('DELETE')
   
                     <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                 </form>
            </div>
             
        </td>
    </tr>
 @endforeach
</table>

{!! $data->links('pagination::bootstrap-5') !!}
@endsection
