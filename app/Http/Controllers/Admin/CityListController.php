<?php
    namespace App\Http\Controllers\Admin;
    use App\Models\Admin\CityList;
    use Date;
    use Illuminate\Http\Request;
    use Yajra\DataTables\Facades\DataTables;
    
    class CityListController extends Controller
    {
        public function index()
        {
            return view('Blogbackend.cityList.index');
        }
    
        public function getCityAjax(Request $request)
        {
            $query = CityList::all();
    
            // Apply date filters if provided
            if ($request->startDate && $request->endDate) {
                $query->whereBetween('created_date', [$request->startDate, $request->endDate]);
            }
            return DataTables::of($query)
                ->addColumn('edit', function ($row) {
                    return '<button class="btn btn-warning editCity" data-id="' . $row->id . '">Edit</button>';
                })
                ->addColumn('delete', function ($row) {
                    return '<button class="btn btn-danger deleteCity" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        }
        
    
        // Store a new city
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:80',
            ]);
    
            $city = new CityList();
            $city->name = $request->name;
            $city->slug = $request->slug;
            $city->is_capital = $request->is_capital;
            $city->currency = $request->currency;
            $city->created_date = now();
            $city->save();
    
            return response()->json(['success' => 'City added successfully!']);
        }
    
        // Fetch a city for editing
        public function edit($id)
        {
            $city = CityList::findOrFail($id);
            return response()->json($city);
        }
    
        // Update a city
        public function update(Request $request, $id)
        {
            $request->validate([
                'name' => 'required|string|max:80',
            ]);
    
            $city = CityList::findOrFail($id);
            $city->name = $request->name;
            $city->slug = $request->slug;
            $city->is_capital = $request->is_capital;
            $city->currency = $request->currency;
            $city->updated_date = now();
            $city->save();
    
            return response()->json(['success' => 'City updated successfully!']);
        }
    
        // Delete a city
        public function destroy($id)
        {
            $city = CityList::findOrFail($id);
            $city->delete();
    
            return response()->json(['success' => 'City deleted successfully!']);
        }
    }
    