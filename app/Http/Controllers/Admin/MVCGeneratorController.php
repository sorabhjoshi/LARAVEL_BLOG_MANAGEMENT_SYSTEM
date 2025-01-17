<?php

namespace App\Http\Controllers\Admin;

use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MVCGeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $modelName = Str::studly(str_replace([' ', '-', '_'], '', $request->input('model')));
        $viewFolder = $request->input('model');
        $routeName = $request->input('model');
        $controllerName = $modelName . 'Controller';

        $modelPath = app_path("Models/Admin/$modelName.php");
        $controllerPath = app_path("Http/Controllers/Admin/{$controllerName}.php");
        $viewPath = resource_path("views/Blogbackend/$viewFolder");
        $routePath = base_path('routes/web.php');

        // Create Model
        if (!File::exists($modelPath)) {
            File::put($modelPath, $this->getModelTemplate($modelName));
        }

        // Create Controller
        if (!File::exists($controllerPath)) {
            File::put($controllerPath, $this->getControllerTemplate($controllerName, $viewFolder));
        }

        // Create View Folder and Files
        if (!File::exists($viewPath)) {
            File::makeDirectory($viewPath, 0755, true);
            File::put("$viewPath/index.blade.php", $this->getViewTemplate('index', $modelName));
            File::put("$viewPath/create.blade.php", $this->getViewTemplate('create', $modelName));
            File::put("$viewPath/edit.blade.php", $this->getViewTemplate('edit', $modelName));
        }

        // Add Route
        $routeContent = "Route::resource('$routeName', App\Http\Controllers\Admin\\$controllerName::class);\n";
        if (!Str::contains(File::get($routePath), $routeContent)) {
            File::append($routePath, $routeContent);
        }

        return response()->json(['message' => 'Success']);
    }

    // Model Template
    protected function getModelTemplate($modelName)
    {
        return "<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class $modelName extends Model
{
    use HasFactory;

    
}";
    }

    // Controller Template
    protected function getControllerTemplate($controllerName, $viewFolder)
    {
        $modelName = Str::studly($viewFolder);
    
        return "<?php
    
    namespace App\Http\Controllers\Admin;
    
    use App\Models\Admin\\$modelName;
    use Illuminate\Http\Request;
    
    class $controllerName extends Controller
    {
        public function index()
        {
            
            return view('Blogbackend.$viewFolder.index');
        }
    
        public function create()
        {
            return view('Blogbackend.$viewFolder.create');
        }
    
        public function store(Request \$request)
        {
           
            return redirect()->route('$viewFolder.index');
        }
    
        public function edit(\$id)
        {
            
            return view('Blogbackend.$viewFolder.edit');
        }
    }";
    }

    // View Template
    protected function getViewTemplate($viewType, $modelName)
    {
        if ($viewType === 'index') {
            return "<h1>$modelName List</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id=\"table-body\">
    </tbody>
</table>";
        }

        return '';
    }
}
