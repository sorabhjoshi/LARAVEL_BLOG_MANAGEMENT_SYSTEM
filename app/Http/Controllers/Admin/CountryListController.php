<?php
    
    namespace App\Http\Controllers\Admin;
    
    use App\Models\Admin\CountryList;
    use DataTables;
    use Illuminate\Http\Request;
    
    class CountryListController extends Controller
    {public function index()
        {
            return view('Blogbackend.Country List.index');

        }
    
        /**
         * Fetch countries for DataTables AJAX.
         */
        public function getcountryAjax(Request $request)
        {
            try {
                
                $query = CountryList::all();
        
                 
                if ($request->startDate) {
                    $query->whereDate('created_at', '>=', $request->startDate);
                }
        
                if ($request->endDate) {
                    $query->whereDate('created_at', '<=', $request->endDate);
                }
        
                return datatables()->of($query)
                
                    ->addColumn('edit', function ($row) {
                        return '<button class="btn btn-primary editCountry" data-id="' . $row->id . '">Edit</button>';
                    })
                    ->addColumn('delete', function ($row) {
                        return '<button class="btn btn-danger deleteCountry" data-id="' . $row->id . '">Delete</button>';
                    })
                    ->rawColumns(['edit', 'delete'])
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    
        /**
         * Store a new country.
         */
        public function store(Request $request)
        {
            $request->validate([
                'countryname' => 'required|string|max:255',
            ]);
    
            $country = CountryList::create([
                'name' => $request->countryname,
            ]);
    
            return response()->json(['success' => 'Country added successfully!']);
        }
    
        /**
         * Edit an existing country.
         */
        public function edit($id)
        {
            $country = CountryList::findOrFail($id);
            return response()->json($country);
        }
    
        /**
         * Update an existing country.
         */
        public function update(Request $request, $id)
        {
            $request->validate([
                'countryname' => 'required|string|max:255',
            ]);
    
            $country = CountryList::findOrFail($id);
            $country->update([
                'name' => $request->countryname,
            ]);
    
            return response()->json(['success' => 'Country updated successfully!']);
        }
    
        /**
         * Delete a country.
         */
        public function destroy($id)
        {
            $country = CountryList::findOrFail($id);
            $country->delete();
    
            return response()->json(['success' => 'Country deleted successfully!']);
        }
    }