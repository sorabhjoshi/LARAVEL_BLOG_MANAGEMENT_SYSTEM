<?php
    
    namespace App\Http\Controllers\Admin;
    
    use App\Models\Admin\Project;
    use Illuminate\Http\Request;
    
    class ProjectController extends Controller
    {
        public function index()
        {
            
            return view('Blogbackend.Project.index');
        }
    
        public function create()
        {
            return view('Blogbackend.Project.create');
        }
    
        public function store(Request $request)
        {
           
            return redirect()->route('Project.index');
        }
    
        public function edit($id)
        {
            
            return view('Blogbackend.Project.edit');
        }
    }