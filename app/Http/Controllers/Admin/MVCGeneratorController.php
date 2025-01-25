<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MVCGeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $modelName = $request->input('model');
        $tableName = $request->input('table');

        // Ensure the table exists
        if (!Schema::hasTable($tableName)) {
            return back()->with('error', "Table '$tableName' does not exist.");
        }

        $columns = Schema::getColumnListing($tableName);

        return view('Blogbackend.Utils.GenerateMVC', compact('tableName', 'columns', 'modelName'));
    }

    public function generatingmvc(Request $request)
    {
        $modelName = Str::studly(str_replace(['-', '_'], ' ', $request->input('model'))); 
        $columns = $request->input('columns');
        $tableName = $request->input('table');

        if (!$columns) {
            return back()->with('error', 'Please select at least one column.');
        }

        // Paths for generated files
        $modelPath = app_path("Models/Admin/$modelName.php");
        $controllerPath = app_path("Http/Controllers/Admin/{$modelName}Controller.php");
        $viewPath = resource_path("views/Blogbackend/" . strtolower($modelName));
        $routePath = base_path('routes/web.php');
        $routeName = strtolower($modelName); // Route name (lowercase)

        // Generate Model
        if (!File::exists($modelPath)) {
            File::put($modelPath, $this->getModelTemplate($modelName, $columns, $tableName));
        }

        // Generate Controller
        if (!File::exists($controllerPath)) {
            File::put($controllerPath, $this->getControllerTemplate($modelName,$columns));
        }

        // Create View Directory and Files
        if (!File::exists($viewPath)) {
            File::makeDirectory($viewPath, 0755, true);

            File::put("$viewPath/index.blade.php", $this->getViewTemplate('index', $modelName, $columns));
            File::put("$viewPath/create.blade.php", $this->getViewTemplate('create', $modelName, $columns));
            File::put("$viewPath/edit.blade.php", $this->getViewTemplate('edit', $modelName, $columns));
        }

        // Add Route
        $routeContent = "Route::resource('$routeName', App\Http\Controllers\Admin\\{$modelName}Controller::class);\n";
        if (!Str::contains(File::get($routePath), $routeContent)) {
            File::append($routePath, $routeContent);
        }

        return redirect()->route('home')->with('success', 'MVC files generated successfully!');
    }

    protected function getModelTemplate($modelName, $columns, $tableName)
    {
        $fillable = implode(",\n        ", array_map(function ($col) {
            return "'$col'";
        }, $columns));

        return "<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class $modelName extends Model
{
    use HasFactory;

    protected \$table = '$tableName';

    protected \$fillable = [
        $fillable
    ];
}
";
    }

    protected function getControllerTemplate($modelName, $columns)
    {
        $validationRules = implode(",\n            ", array_map(fn($col) => "'$col' => 'required'", $columns));
        $cols = implode(", ", array_map(fn($col) => "'$col'", $columns));

        return "<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\\$modelName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class {$modelName}Controller extends Controller
{
    public function index()
    {
        \$columns = [$cols];
        \${$modelName} = $modelName::all();
        return view('Blogbackend." . strtolower($modelName) . ".index', compact('$modelName', 'columns'));
    }

    public function create()
    {
        return view('Blogbackend." . strtolower($modelName) . ".create');
    }

    public function store(Request \$request)
    {
        \$validated = \$request->validate([
            $validationRules
        ]);

        $modelName::create(\$validated);

        return redirect()->route('" . strtolower($modelName) . ".index')
            ->with('success', 'Record created successfully!');
    }

    public function edit(\$id)
    {
        \${$modelName} = $modelName::findOrFail(\$id);
        return view('Blogbackend." . strtolower($modelName) . ".edit', compact('$modelName'));
    }

    public function update(Request \$request, \$id)
    {
        \$validated = \$request->validate([
            $validationRules
        ]);

        \${$modelName} = $modelName::findOrFail(\$id);
        \${$modelName}->update(\$validated);

        return redirect()->route('" . strtolower($modelName) . ".index')
            ->with('success', 'Record updated successfully!');
    }

    public function destroy(\$id)
    {
        \${$modelName} = $modelName::findOrFail(\$id);
        \${$modelName}->delete();

        return redirect()->route('" . strtolower($modelName) . ".index')
            ->with('success', 'Record deleted successfully!');
    }
}
";
    }

    protected function getViewTemplate($viewName, $modelName, $columns)
    {
         // Ensure $columns is treated as an array of strings.
    $columnsHtml = implode("\n", array_map(fn($col) => "<th>{{ ucfirst('$col') }}</th>", $columns));
    
    // Check if 'id' exists in the columns and add it as a hidden field if present
    $fieldsHtml = implode("\n", array_map(function ($col) use ($modelName) {
        // If the column is 'id', add it as a hidden input
        if ($col == 'id') {
            return "<input type='hidden' name='$col' value='{{ isset(\$$modelName) ? \$$modelName->$col : '' }}'>";
        }

        return "
        <div class='form-group'>
            <label for='$col'>{{ ucfirst('$col') }}</label>
            <input type='text' name='$col' id='$col' value='{{ isset(\$$modelName) ? \$$modelName->$col : '' }}' class='form-control' required>
        </div>";
    }, $columns));


        switch ($viewName) {
            case 'index':
                return "
@extends('Blogbackend.components.layout')

@section('content')
    <style>
        /* Custom Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-buttons a, .action-buttons button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .action-buttons button {
            background-color: #dc3545;
        }
            .action-buttons a{
            text-decoration: none;
        }
            h1{
            padding: 10px;
            background-color: #4b5c70;
            border-radius: 10px;    
            margin: 10px 0;
            color: white
        }
            .adddata{
            padding: 10px;
            background-color: #4b5c70;
            border-radius: 10px;    
            margin: 10px 0;
            color: white;
            text-decoration: none;
            display: block;
            width: 150px;
        }
            .adddata:hover{
            background-color: #2c3e50;
            color: white;
            }
            
    </style>
    <div class='container'>
        <h1>List of $modelName</h1>
        <table>
            <thead>
                <tr>
                    $columnsHtml
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    @foreach ($$modelName as \$model)
        <tr>
            @foreach (\$columns as \$column)
                <td>{{ \$model->\$column }}</td>
            @endforeach
            <td class='action-buttons'>
                <a href=\"{{ route(strtolower('$modelName') . '.edit', \$model->id) }}\"><i class='fas fa-edit'></i></a>
                <form action=\"{{ route(strtolower('$modelName') . '.destroy', \$model->id) }}\" method=\"POST\">
                    @csrf
                    @method('DELETE')
                    <button type=\"submit\"><i class='fas fa-trash-alt'></i></button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
        </table>
        <a class='adddata' href='{{ route('" . strtolower($modelName) . ".create') }}'>Create New</a>
    </div>
@endsection
";
            case 'create':
                return "
@extends('Blogbackend.components.layout')

@section('content')
    <style>
        /* Custom Styles */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type='text'] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type='submit'] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .containercreate{
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        button[type='submit']:hover {
            background-color: #218838;
        }
    </style>
    <div class='containercreate'>
        <h1>Create $modelName</h1>
        <form action='{{ route('" . strtolower($modelName) . ".store') }}' method='POST'>
            @csrf
            $fieldsHtml
            <button type='submit'>Create</button>
        </form>
    </div>
@endsection
";
            case 'edit':
                return "
@extends('Blogbackend.components.layout')

@section('content')
    <style>
        /* Custom Styles */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type='text'] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type='submit'] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .containercreate{
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        button[type='submit']:hover {
            background-color: #0056b3;
        }
    </style>
    <div class='containercreate'>
        <h1>Edit $modelName</h1>
        <form action='{{ route('" . strtolower($modelName) . ".update', $$modelName->".str_replace("/", "", "/id").") }}' method='POST'>
            @csrf
            @method('PUT')
            $fieldsHtml
            <button type='submit'>Update</button>
        </form>
    </div>
@endsection
";
        }
    }
}
