<?php

namespace App\Http\Controllers;

use App\Models\InvCategory;
use App\Models\InvLocation;
use App\Models\InvProduct;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InvProductController extends Controller
{
     public function index()
    {

        return view('inv_products.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = InvProduct::select([
                'id',
                'code',
                'name',
                'description',
                'category_id',
                'location_id',
            ])->with(['category', 'location']);

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
        // Code to show form for creating a new inventory product
        $invCategories = InvCategory::all();
        $invLocations = InvLocation::all();
         return view('inv_products.form', compact('invCategories', 'invLocations'));
    }

    public function store(Request $request)
    {
        // Code to save a new location
         $request->validate([
        'code' => 'required|unique:inv_products',
        'name'  => 'required',
        'description' => 'nullable',
        'category_id' => 'required',
        'location_id' => 'required'
    ]);

    InvProduct::create($request->all());

    return redirect()
        ->route('inv-product.index')
        ->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        // Code to display a specific location
        $invLocations = InvProduct::findOrFail($id);
        dd($invLocations);
    }

    public function edit($id)
    {
        $invProducts = InvProduct::findOrFail($id);
        // dd($invProducts);
        // Code to show form for editing an inventory product
        $invCategories = InvCategory::all();
        $invLocations = InvLocation::all();
        return view('inv_products.form', compact('invCategories', 'invLocations', 'invProducts'));

    }

    public function update(Request $request, InvProduct $invProducts)
    {
        // Code to update a specific inventory product
         $request->validate([
        'code' => 'required|unique:inv_products,code,' . $invProducts->id,
        'name'  => 'required',
        'description' => 'nullable',
         'category_id' => 'required',
         'location_id' => 'required'

        // 'email' => 'required|email',
        // 'phone' => 'nullable',
    ]);

    $invProducts->update($request->all());

    return redirect()
        ->route('inv-product.index')
        ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
{
    $invProducts = InvProduct::findOrFail($id);

    $invProducts->delete();

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil dihapus'
    ]);
}
}
