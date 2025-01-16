<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MVCGeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $modelName = Str::studly($request->input('model'));
        $viewFolder = $request->input('view');
        $routeName = $request->input('route');
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
        $routecontrollercall = "App\Http\Controllers\Admin\{$controllerName}";
        $routeContent = "Route::resource('$routeName', {$controllerName}::class);\n";
        if (!Str::contains(File::get($routePath), $routeContent)) {
            File::append($routePath, $routeContent);
            File::append($routePath, $routecontrollercall);
        }

        return redirect()->route('addmodule')->with('success', 'MVC structure created successfully!');
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
        return "<?php

        namespace App\Http\Controllers\Admin;

        use App\Models\Admin\\" . Str::studly($viewFolder) . ";
        use Illuminate\Http\Request;

        class $controllerName extends Controller
        {
            public function index()
            {
                \$$viewFolder = " . Str::studly($viewFolder) . "::all();
                return view('Blogbackend.$viewFolder.index', compact('$viewFolder'));
            }

            public function create()
            {
                return view('$viewFolder.create');
            }

            public function store(Request \$request)
            {
                " . Str::studly($viewFolder) . "::create(\$request->all());
                return redirect()->route('$viewFolder.index');
            }

            public function edit( \$id){
                \$$viewFolder = " . Str::studly($viewFolder) . "::find(\$id);
                if ($viewFolder) {
                    return view('Blogbackend.$viewFolder.index', compact('$viewFolder'));

                } else {
                   echo'not found'; die;
                }
            }
           public function update(Request \$request)
            {
                \$id= \$request->input('id');

                \$record = " . Str::studly($viewFolder) . "::findOrFail(\$id);

                \$record->update(\$request->all());

                return redirect()->route('$viewFolder.index')->with('success', 'Record updated successfully!');
            }


               public function delete(\$id)
                {
                  \$$viewFolder = " . Str::studly($viewFolder) . "::find(\$id);

                    if (\$$viewFolder) {
                       
                        \$record->delete();

                        return redirect()->route('$viewFolder.index')->with('success', 'Record deleted successfully!');
                    } else {
                        return redirect()->route('$viewFolder.index')->with('error', 'Record not found.');
                    }
                }


        }";
    }

    // View Template
    protected function getViewTemplate($viewType, $modelName)
    {
        if ($viewType === 'index') {
            return "<h1>$modelName List</h1>";
        }

        return '';
    }
}