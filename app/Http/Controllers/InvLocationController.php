<?php

namespace App\Http\Controllers;

use App\Models\InvLocation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InvLocationController extends Controller
{
    public function index()
    {

        return view('inv_locations.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = InvLocation::select([
                'id',
                'name',
                'description',
            ]);

            return DataTables::of($query)

                ->addColumn('action', function ($row) {

                    $edit = '
                        <button class="btn btn-xs btn-primary btn-edit"
                            data-id="'.$row->id.'">
                            <i class="fas fa-edit"></i>
                        </button>
                    ';

                    $delete = '
                        <button class="btn btn-xs btn-danger btn-delete"
                            data-id="'.$row->id.'">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';

                    $detail = '
                        <button class="btn btn-xs btn-info btn-detail"
                            data-id="'.$row->id.'">
                            <i class="fas fa-eye"></i>
                        </button>
                    ';

                    return $edit . ' ' . $delete . ' ' . $detail;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function create()
    {
        // Code to show form for creating a new inventory location
         return view('inv_locations.form');
    }

    public function store(Request $request)
    {
        // Code to save a new location
         $request->validate([
        'name'  => 'required',
        'description' => 'nullable'
    ]);

    InvLocation::create($request->all());

    return redirect()
        ->route('inv-location.index')
        ->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        // Code to display a specific location
        $invLocations = InvLocation::findOrFail($id);
        dd($invLocations);
    }

    public function edit($id)
    {
        $invLocations = InvLocation::findOrFail($id);
        // dd($invLocations);
        // Code to show form for editing an inventory location
        return view('inv_locations.form', compact('invLocations'));

    }

    public function update(Request $request, InvLocation $invLocations)
    {
        // Code to update a specific inventory location
         $request->validate([
        'name'  => 'required',
        'description' => 'nullable',
        // 'email' => 'required|email',
        // 'phone' => 'nullable',
    ]);

    $invLocations->update($request->all());

    return redirect()
        ->route('inv-location.index')
        ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
{
    $location = InvLocation::findOrFail($id);

    $location->delete();

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil dihapus'
    ]);
}
}
