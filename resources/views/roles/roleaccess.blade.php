@extends('Blogbackend.components.layout')

@section('content')
<style>
    .content{
        display: flex;
        justify-content: center;
        align-content: center   ;

    }
    .design{
        background-color: #c2c2c2;
        width: 40vw;
        padding: 30px;
        border-radius: 10px;
        height: fit-content;
        margin: 20px;
    }
    form{
        margin-left: 20px;
    }
    .rows{
        text-align: center;
    }
</style>
<div class="design">
    <div class="rows">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Manage Access</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href=""><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
    
    <form method="POST" action="{{ route('roles.updateAccess', ['roleId' => $roleId]) }}">
        @csrf
        <ul>
            <div class="row">
                @foreach($modules as $module)
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <div style="padding-left:5px;">
                                <label>
                                    <input type="checkbox" class="category-checkbox" data-category="{{ $module->modulesname }}">
                                    <strong>{{ $module->modulesname }}</strong>
                                </label>
    
                                <div class="ml-4" style="padding-left:10px;border-left:1px solid gray;margin-left:8px;">
                                    <div>
                                        <input type="checkbox" class="menu-checkbox" data-category="{{ $module->modulesname }}" value="show menu"> Show Menu
                                    </div>
                                    <div class="form-group p-2" style="margin-left:8px;border-left:1px solid gray;">
                                        @foreach($module->permission as $permission)
                                            <div>
                                                <label>
                                                    <input 
                                                        type="checkbox" 
                                                        name="permissions[]" 
                                                        class="permission-checkbox" 
                                                        data-category="{{ $module->modulesname }}" 
                                                        value="{{ $permission->id }}"
                                                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group p-2" style="margin-left:8px;border-left:1px solid gray;">
                                        @foreach($module->childmodule as $childmod)
                                            <div>
                                                <label>
                                                    <input 
                                                        type="checkbox" 
                                                        class="category-checkbox" 
                                                        data-category="{{ $childmod->modulesname }}">
                                                    <strong>{{ $childmod->modulesname }}</strong>
                                                </label>
                                                <div class="form-group p-2" style="margin-left:8px;border-left:1px solid gray;">
                                                    @foreach($childmod->permission as $permission)
                                                        <div>
                                                            <label>
                                                                <input 
                                                                    type="checkbox" 
                                                                    name="permissions[]" 
                                                                    class="permission-checkbox" 
                                                                    data-category="{{ $childmod->modulesname }}" 
                                                                    value="{{ $permission->id }}"
                                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </ul>
    
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </div>
    </form>

</div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.category-checkbox').forEach(categoryCheckbox => {
            categoryCheckbox.addEventListener('change', function () {
                const category = this.getAttribute('data-category');
                const isChecked = this.checked;

                document.querySelectorAll(`.menu-checkbox[data-category="${category}"], .permission-checkbox[data-category="${category}"]`).forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });
        });

        document.querySelectorAll('.menu-checkbox').forEach(menuCheckbox => {
            menuCheckbox.addEventListener('change', function () {
                const category = this.getAttribute('data-category');
                const isChecked = this.checked;

                document.querySelectorAll(`.permission-checkbox[data-category="${category}"]`).forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
