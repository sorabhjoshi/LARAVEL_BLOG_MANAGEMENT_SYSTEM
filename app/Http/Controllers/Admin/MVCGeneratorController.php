<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
class MVCGeneratorController extends Controller
{
    public function getColumns($table)
    {
        // Get the column list from the table
        $columns = Schema::getColumnListing($table);
    
        return response()->json(['columns' => $columns]);
    }
    // web.php

// TableController.php
public function getTableColumns($table)
{   
    try {
        // Fetch column names from the database
        $columns = Schema::getColumnListing($table);

        return response()->json(['columns' => $columns]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Unable to fetch columns.'], 500);
    }
}

    public function generate(Request $request)
    {
        
        $tables = DB::select('SHOW TABLES');
        $tableNames = [];
        foreach ($tables as $table) {
            foreach ($table as $tableName) {
                $tableNames[] = $tableName;
            }
        }
        $modelName = $request->input('model');
        $tablename =  $request->input('table');
        $columns = Schema::getColumnListing($tablename);
        return view('Blogbackend.Utils.GenerateMVC', compact('columns', 'modelName', 'tablename','tableNames'));
        // return view('Blogbackend.Utils.GenerateMVC', compact('tableName', 'columns', 'modelName','tableNames'));
    }
    public function mvc(Request $request)
    {   
        $selectedData = json_decode($request->input('selected_data'), true);
        $inputTypes = $request->input('inputTypes', []);
        $module = $request->modelName;
        $tablename = $request->tablename;
        $columns = $request->input('columns', []);

        if (!$module) {
            return redirect()->back()->withErrors('Module not found');
        }

        // Format module names
        $module_name = ucfirst(strtolower(str_replace(' ', '', $module)));
        $plural_module_name = $module_name . 's';

        // Paths for MVC components
        $modelPath = app_path("Models/$plural_module_name.php");
        $controllerPath = app_path("Http/Controllers/Admin/{$module_name}Controller.php");
        $viewDirectory = resource_path("views/Blogbackend/$module_name");
        // Cleanup existing files
        $this->cleanupFiles($modelPath, $controllerPath, $viewDirectory);
        // Generate Model and Controller
        Artisan::call("make:model $plural_module_name");
        Artisan::call("make:controller Admin/{$module_name}Controller");

        $this->updateModel($modelPath, $tablename);
        // Generate Controller Methods
        $this->updateController($controllerPath, $tablename, $columns, $module_name);

        // Generate Views
        $this->generateViews($viewDirectory, $module_name, $tablename, $columns, $inputTypes,$selectedData);

        // Clear View Cache
        Artisan::call('view:clear');

        // Register Routes
        $this->registerRoutes($module_name);

        return redirect('/Admin/Modules')->with('success', 'MVC structure recreated successfully.');
    }

    protected function cleanupFiles($modelPath, $controllerPath, $viewDirectory)
    {
        if (file_exists($modelPath))
            unlink($modelPath);
        if (file_exists($controllerPath))
            unlink($controllerPath);
        if (File::exists($viewDirectory))
            File::deleteDirectory($viewDirectory);
    }

    protected function updateController($controllerPath, $tablename, $columns, $module_name)
    {
        $columnsString = implode("', '", $columns);
        $methods = <<<EOD
    // Index method
    public function index()
    {
        \$columns = ['$columnsString'];
        \$data = DB::table("$tablename")->select(\$columns)->get();
        return view('Blogbackend.$module_name.index', compact('columns', 'data'));
    }
    
    // Create method
    public function create()
    {
        return view('Blogbackend.$module_name.create');
    }
    
    // Edit method
    public function edit(\$id)
    {
        \$columns = ['$columnsString'];
        \$text = DB::table('$tablename')->where('id', \$id)->first();
        return view('Blogbackend.$module_name.edit', compact('text', 'columns'));
    }
    
    // Store method
    public function store(Request \$request)
    {
        // Define dynamic validation rules
        \$rules = [];
        
        // Generate validation rules based on column types
        foreach (['$columnsString'] as \$col) {
         if (\$col == 'id') {
                continue;
            }
            \$type = \$inputTypes[\$col] ?? 'string';  // Default to 'string' if no type is specified
            
            if (\$type == 'text' || \$type == 'string') {
                \$rules[\$col] = 'required|string|max:255';
            } elseif (\$type == 'number' || \$type == 'integer') {
                \$rules[\$col] = 'required|integer';
            } elseif (\$type == 'email') {
                \$rules[\$col] = 'required|email';
            } elseif (\$type == 'date') {
                \$rules[\$col] = 'required|date';
            } else {
                \$rules[\$col] = 'required';
            }
        }

        // Validate the incoming request data
        \$validatedData = \$request->validate(\$rules);
         if(array_key_exists('image', \$validatedData)){
            \$validatedData['image'] =\$request->image;
        }
        // Insert validated data into the database
        DB::table('$tablename')->insert(\$validatedData);

        return redirect('/$module_name')->with('success', '$module_name created successfully.');
    }
    
    // Update method
    public function update(Request \$request)
    {
        // Define dynamic validation rules
        \$rules = [];
        
        // Generate validation rules based on column types
        foreach (['$columnsString'] as \$col) {
            \$type = \$inputTypes[\$col] ?? 'string';  // Default to 'string' if no type is specified
            
            // Skip the 'id' column for validation
            if (\$col == 'id') {
                continue;
            }
            
            if (\$type == 'text' || \$type == 'string') {
                \$rules[\$col] = 'required|string|max:255';
            } elseif (\$type == 'number' || \$type == 'integer') {
                \$rules[\$col] = 'required|integer';
            } elseif (\$type == 'email') {
                \$rules[\$col] = 'required|email';
            } elseif (\$type == 'date') {
                \$rules[\$col] = 'required|date';
            } else {
                \$rules[\$col] = 'required';
            }
        }

        // Validate the incoming request data
        \$validatedData = \$request->validate(\$rules);
        if(array_key_exists('image', \$validatedData)){
            \$validatedData['image'] =\$request->image;
        }
        // Update validated data in the database
        DB::table('$tablename')->where('id', \$request->id)->update(\$validatedData);

        return redirect('/$module_name')->with('success', '$module_name updated successfully.');
    }
    
    // Delete method
    public function delete(\$id)
    {
        DB::table('$tablename')->where('id', \$id)->delete();
        return redirect('/$module_name')->with('success', '$module_name deleted successfully.');
    }
EOD;


        // Read the controller content
        $controllerContent = file_get_contents($controllerPath);

        // Add use statement below the namespace declaration
        $controllerContent = preg_replace('/namespace\s+[A-Za-z0-9\\\]+;/', '$0' . "\nuse Illuminate\Support\Facades\DB;", $controllerContent);

        // Insert the methods into the controller
        $controllerContent = preg_replace('/\{/', "{\n" . $methods, $controllerContent, 1);

        // Write the updated content back to the controller file
        file_put_contents($controllerPath, $controllerContent);
    }
    protected function generateViews($viewDirectory, $module_name, $tablename, $columns, $inputTypes, $selectedData)
    {
        File::makeDirectory($viewDirectory, 0755, true);
    
        // Ensure 'id' is part of the columns for processing, but it won't be displayed in the table or form
        if (!in_array('id', $columns)) {
            array_unshift($columns, 'id'); // Add 'id' as the first column
        }
    
        // Index View
        $tableHeaders = '';
        $indexContent = <<<EOD
        @extends('Blogbackend.components.layout')
        <link rel="stylesheet" href="{{ asset('css/Backend/blog.css') }}">
        <?php
        use Illuminate\Support\Facades\DB;
        ?>
        @section('content')
        <div class="info" style="background: white;">
        <div class="container mt-4">
            <h2>$module_name List</h2>
        <a href="{{ '/' . lcfirst('$module_name') . '/create' }}" class="btn btn-primary">Add $module_name</a>
        <table id="table">
            <thead>
                <tr>
                </div>
                </div>
        EOD;
    
        // Add table headers dynamically, excluding 'id' from being shown
        foreach ($columns as $col) {
            if ($col != 'id') {
                $tableHeaders .= "<th>" . ucfirst($col) . "</th>";
            }
        }
    
        $indexContent .= $tableHeaders . "<th>Actions</th></tr></thead><tbody>";
    
        // Add rows, excluding 'id' from being shown in the table
        $indexContent .= <<<EOD
            @foreach(\$data as \$row)
            <tr>
        EOD;
    
        foreach ($columns as $col) {
            if ($col != 'id') {
                $indexContent .= "<td>{{ \$row->$col }}</td>";
            }
        }
    
        $indexContent .= <<<EOD
                <td>
                    <a href="{{ '/' . '$module_name' . '/edit/' . \$row->id }}" class="btn btn-warning">Edit</a>
                    <form action="{{ '/' . '$module_name' . '/delete/' . \$row->id }}" method="POST" style="display:inline;">
                    @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Open file manager on button click
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();
            window.open('/file-manager/fm-button', 'fm', 'width=700,height=400');
        });
    });

    // Set image link after selection from file manager
    function fmSetLink(\$url) {
        const modifiedUrl = \$url.replace(/^https?:\/\/[^\/]+\//, ''); // Removes protocol and domain
        document.getElementById('image').value = modifiedUrl; // Set value to the image input field
    }
    </script>
    @endsection
    EOD;
    
        // Helper function to generate select2 field
        function generateSelect2Field($col, $config) {
            $coll = ucwords($col);
            if ($config['method'] === 'table') {
                return "
                <div class='input-group'>
                    <label>$coll</label><br>
                    <select class='form-control select2' name='$col' id='$col'>
                        <option value=''>Select $coll</option>
                        @foreach(DB::table('{$config['table']}')->select('{$config['column']}')->distinct()->get() as \$item)
                            <option value='{{ \$item->{$config['column']} }}'>
                                {{ \$item->{$config['column']} }}
                            </option>
                        @endforeach
                    </select>
                </div>";
            } else {
                $options = array_combine(
                    explode(',', $config['key']), 
                    explode(',', $config['value'])
                );
                $optionsHtml = '';
                foreach ($options as $key => $value) {
                    $optionsHtml .= "<option value='$key'>$value</option>";
                }
                return "
                <div class='input-group'>
                    <label>$coll</label><br>
                    <select class='form-control select2' name='$col' id='$col'>
                        <option value=''>Select $coll</option>
                        $optionsHtml
                    </select>
                </div>";
            }
        }
    
        // Create View
        $formFields = '';
        foreach ($inputTypes as $col => $type) {
            if ($col != 'id') {
                if ($type === 'select2') {
                    // Find configuration for this select2 field
                    $config = collect($selectedData)->firstWhere('columnName', $col);
                    if ($config) {
                        $formFields .= generateSelect2Field($col, $config);
                    }
                } elseif ($type === 'file') {
                    // Special handling for file input
                    $coll = ucwords($col);
                    $formFields .= "
                    <div class='mb-3'>
                        <label class='form-label fw-bold'>$coll</label><br>
                        <div class='d-flex flex-column align-items-center'>
                            <div class='input-group'>
                                <input type='text' id='image_label' class='form-control' name='image'
                                       placeholder='Select an image...' aria-label='Image'>
                                <button class='btn btn-outline-secondary' type='button' id='button-image'>Select</button>
                            </div>
                        </div>
                    </div>";
                } else {
                    // Existing input field generation code for other types (text, number, etc.)
                    $coll = ucwords($col);
                    $formFields .= " 
                    <div class='input-group'>
                        <label>$coll</label><br>
                        <input type='$type' name='$col' />
                    </div>";
                }
            }
        }
        
    
        // Add select2 initialization script
        $createContent = <<<EOD
        @extends('Blogbackend.components.layout')
        <link rel="stylesheet" href="{{ asset('css/Backend/create.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
         <?php
        use Illuminate\Support\Facades\DB;
        ?>
        @section('content')
        <main id="main" class="main">
            <h1 class="header">Create $module_name</h1>
            <form class="simple" method="post" action="/$module_name/store" enctype="multipart/form-data">
                <div class="form1">
                    @csrf
                    $formFields
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </main>
        @endsection
    
        @section('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    width: '100%',
                    placeholder: 'Select an option'
                });
            });
        </script>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
        // Open file manager on button click
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();
            window.open('/file-manager/fm-button', 'fm', 'width=700,height=400');
        });
        });

        // Set image link after selection from file manager
        function fmSetLink(\$url) {
        const modifiedUrl = \$url.replace(/^https?:\/\/[^\/]+\//, ''); // Removes protocol and domain
        document.getElementById('image').value = modifiedUrl; // Set value to the image input field
        }
        </script>
        @endsection
        EOD;
    
        // Edit View - Similar modifications for edit view
        $editFields = '';
        foreach ($inputTypes as $col => $type) {
            if ($col === 'id') {
                // For 'id', we keep it as a hidden input with the current value
                $editFields .= "<input type='hidden' name='$col' value='{{ \$text->$col }}' />";
            } else {
                if ($type === 'select2') {
                    // Handle select2 fields
                    $config = collect($selectedData)->firstWhere('columnName', $col);
                    if ($config) {
                        $editFields .= generateSelect2Field($col, $config, "{{ \$item->$col }}");
                    }
                } elseif ($type === 'file') {
                    // Special handling for file input type
                    $coll = ucwords($col);
                    $editFields .= "
                    <div class='mb-3'>
                      <label class='form-label fw-bold'>$coll</label><br>
                      <div class='d-flex flex-column align-items-center'>
                          <img src='{{ asset(\$text->$col) }}' alt='Uploaded Image' class='img-thumbnail mb-2' height='100' width='100'>
                          <div class='input-group'>
                              <input type='text' id='image_label' class='form-control' name='image'
                                  placeholder='Select an image...' aria-label='Image'>
                              <button class='btn btn-outline-secondary' type='button' id='button-image'>Select</button>
                          </div>
                      </div>
                  </div>";
                } else {
                    // Handle other input types (text, number, etc.)
                    $coll = ucwords($col);
                    $editFields .= " 
                    <div class='input-group'>
                        <label>$coll</label><br>
                        <input type='$type' name='$col' value='{{ \$text->$col }}' />
                    </div>";
                }
            }
        }
        
    
        $editContent = <<<EOD
        @extends('Blogbackend.components.layout')
        <link rel="stylesheet" href="{{ asset('css/Backend/create.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <?php
        use Illuminate\Support\Facades\DB;
        ?>
        @section('content')
        <main id="main" class="main">
            <h1 class="header">Edit $module_name</h1>
            <form class="simple" method="post" action="/$module_name/update" enctype="multipart/form-data">
                <div class="form1">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="tablename" value="$tablename">
                    $editFields
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </main>
        @endsection
    
        @section('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    width: '100%',
                    placeholder: 'Select an option'
                });
            });
        </script>
        <script>
          document.addEventListener("DOMContentLoaded", function() {
        // Open file manager on button click
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();
            window.open('/file-manager/fm-button', 'fm', 'width=700,height=400');
        });
        });

            // Set image link after selection from file manager
         function fmSetLink(\$url) {
        const modifiedUrl = \$url.replace(/^https?:\/\/[^\/]+\//, ''); // Removes protocol and domain
        document.getElementById('image').value = modifiedUrl; // Set value to the image input field
        }
        </script>
        @endsection
        EOD;
    
        // Save views
        file_put_contents("$viewDirectory/index.blade.php", $indexContent);
        file_put_contents("$viewDirectory/create.blade.php", $createContent);
        file_put_contents("$viewDirectory/edit.blade.php", $editContent);
    }
    
    private function updateModel($modelPath, $tablename)
    {
        if (file_exists($modelPath)) {
            $modelContent = file_get_contents($modelPath);

            // Add the $table property if it doesn't already exist
            if (!str_contains($modelContent, '$table')) {
                $tableProperty = "\n    protected \$table = '$tablename';\n";
                $modelContent = preg_replace('/class\s+\w+\s+extends\s+Model\s*\{/', "$0$tableProperty", $modelContent);
                file_put_contents($modelPath, $modelContent);
            }
        }
    }

    protected function registerRoutes($module_name)
    {
        $routePath = base_path('routes/web.php');

        // Read the current content of the routes file
        $routeContent = file_get_contents($routePath);

        // Regular expression to find existing routes for the module
        $pattern = "/Route::get\('\/$module_name.?delete\('.?\);/s";

        // Remove the existing routes if any
        $updatedRouteContent = preg_replace($pattern, '', $routeContent); 

        // Append the new routes to the updated content
        $routes = <<<EOD
// $module_name Routes
Route::get('/$module_name', [\App\Http\Controllers\Admin\\{$module_name}Controller::class, 'index'])->name('$module_name');
Route::get('/$module_name/create', [\App\Http\Controllers\Admin\\{$module_name}Controller::class, 'create']);
Route::post('/$module_name/store', [\App\Http\Controllers\Admin\\{$module_name}Controller::class, 'store']);
Route::get('/$module_name/edit/{id}', [\App\Http\Controllers\Admin\\{$module_name}Controller::class, 'edit']);
Route::post('/$module_name/update', [\App\Http\Controllers\Admin\\{$module_name}Controller::class, 'update']);
Route::post('/$module_name/delete/{id}', [\App\Http\Controllers\Admin\\{$module_name}Controller::class, 'delete']);
EOD;

        // Append the new routes to the file
        file_put_contents($routePath, $updatedRouteContent . $routes);
    }
}
