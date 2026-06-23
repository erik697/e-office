<?php

namespace App\Http\Controllers;

use App\Models\DsrFile;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DsrFileController extends Controller
{
    public function index()
    {

        return view('dsr_files.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = DsrFile::select([
                'id',
                'title',
                'description',
                'file_path',
                'category_id',
                'staff_id',
            ])->with('category', 'staff');

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
         return view('dsr_files.form');
    }

    public function store(Request $request)
    {
        // Code to save a new inventory category
         $request->validate([
        'title'  => 'required',
        'description' => 'required|nullable',
        'file_path' => 'required',
        'category_id' => 'required|exists:dsr_categories,id',
        'staff_id' => 'required|exists:staff,id',
    ]);

    DsrFile::create($request->all());

    return redirect()
        ->route('dsr-file.index')
        ->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        // Code to display a specific inventory category
        $invCategories = DsrFile::findOrFail($id);
        dd($invCategories);
    }

    public function edit($id)
    {
        $invCategories = DsrFile::findOrFail($id);
        // dd($invCategories);
        // Code to show form for editing an inventory category
        return view('dsr_files.form', compact('invCategories'));

    }

    public function update(Request $request, DsrFile $drsFiles)
    {
    
        // Code to update a specific inventory category
         $request->validate([
        'title'  => 'required',
        'description' => 'required|nullable',
        'file_path' => 'required',
        'category_id' => 'required|exists:dsr_categories,id',
        'staff_id' => 'required|exists:staff,id',
        // 'email' => 'required|email',
        // 'phone' => 'nullable',
    ]);

    $drsFiles->update($request->all());

    return redirect()
        ->route('dsr-file.index')
        ->with('success', 'Data berhasil diupdate');
    
    }

    public function destroy($id)
    {
        $category = DsrFile::findOrFail($id);

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
