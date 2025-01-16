<?php

        namespace App\Http\Controllers\Admin;


        use App\Models\Admin\Service;
        use Illuminate\Http\Request;

        class ServiceController extends Controller
        {
            public function index()
            {
                $service = Service::all();
                return view('Blogbackend.service.index', compact('service'));
            }

            public function create()
            {
                return view('Blogbackend.service.create');
            }

            public function store(Request $request)
            {
                Service::create($request->all());
                return redirect()->route('service.index');
            }

            public function edit( $id){
                $service = Service::find($id);
                if (service) {
                    return view('Blogbackend.service.index', compact('service'));

                } else {
                   echo'not found'; die;
                }
            }
           public function update(Request $request)
            {
                $id= $request->input('id');

                $record = Service::findOrFail($id);

                $record->update($request->all());

                return redirect()->route('service.index')->with('success', 'Record updated successfully!');
            }


               public function delete($id)
                {
                  $service = Service::find($id);

                    if ($service) {
                       
                        $record->delete();

                        return redirect()->route('service.index')->with('success', 'Record deleted successfully!');
                    } else {
                        return redirect()->route('service.index')->with('error', 'Record not found.');
                    }
                }


        }