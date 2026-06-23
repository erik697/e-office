<?php

namespace App\Http\Controllers;

use App\Models\DsrCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DsrCategoryController extends Controller
{
   public function index()
    {

        return view('dsr_categories.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = DsrCategory::select([
                'id',
                'name',
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
        // Code to show form for creating a new inventory category
         return view('dsr_categories.form');
    }

    public function store(Request $request)
    {
        // Code to save a new inventory category
         $request->validate([
        'name'  => 'required',
    ]);

    DsrCategory::create($request->all());

    return redirect()
        ->route('dsr-category.index')
        ->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        // Code to display a specific inventory category
        $invCategories = DsrCategory::findOrFail($id);
        dd($invCategories);
    }

    public function edit($id)
    {
        $invCategories = DsrCategory::findOrFail($id);
        // dd($invCategories);
        // Code to show form for editing an inventory category
        return view('dsr_categories.form', compact('invCategories'));

    }

    public function update(Request $request, DsrCategory $invCategories)
    {
        // Code to update a specific inventory category
         $request->validate([
        'name'  => 'required',
        // 'email' => 'required|email',
        // 'phone' => 'nullable',
    ]);

    $invCategories->update($request->all());

    return redirect()
        ->route('dsr-category.index')
        ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $category = DsrCategory::findOrFail($id);

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
