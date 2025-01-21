<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\StateList;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StateListController extends Controller
{
    public function index()
    {
        return view('Blogbackend.stateList.index');
    }

    public function getStatesAjax(Request $request)
    {
        $query = StateList::select(['id', 'name', 'is_active', 'created_date', 'updated_date']);

        // Apply date filters if provided
        if ($request->startDate && $request->endDate) {
            $query->whereBetween('created_date', [$request->startDate, $request->endDate]);
        }

        return DataTables::of($query)
            ->addColumn('edit', function ($row) {
                return '<button class="btn btn-sm btn-primary editState" data-id="' . $row->id . '">Edit</button>';
            })
            ->addColumn('delete', function ($row) {
                return '<button class="btn btn-sm btn-danger deleteState" data-id="' . $row->id . '">Delete</button>';
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
    }

    public function edit($id)
    {
        $state = StateList::find($id);
        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }

        return response()->json($state);
    }

    public function update(Request $request, $id)
    {
        $state = StateList::find($id);
        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $state->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        return response()->json(['success' => 'State updated successfully']);
    }

    public function destroy($id)
    {
        $state = StateList::find($id);
        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }

        $state->delete();
        return response()->json(['success' => 'State deleted successfully']);
    }
}
