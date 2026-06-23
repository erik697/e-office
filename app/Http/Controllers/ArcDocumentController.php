<?php

namespace App\Http\Controllers;

use App\Models\ArcCategory;
use App\Models\ArcDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use SimpleSoftwareIO\Facades\QrCode;

class ArcDocumentController extends Controller
{
     public function index()
    {

        return view('arc_documents.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = ArcDocument::select([
                'id',
                'code',
                'title',
                'description',
                'register',
                'file_path',
                'status',
                'category_id',
                'type',
            ])->with('category');

            if ($request->has('category_id') && !empty($request->category_id)) {
                $query->where('category_id', $request->category_id);
            }
            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }
            if ($request->has('type') && !empty($request->type)) {
                $query->where('type', $request->type);
            }
            if ($request->has('date_from') && !empty($request->date_from)) {
                $query->whereDate('register', '>=', $request->date_from);
            }
            if ($request->has('date_to') && !empty($request->date_to)) {
                $query->whereDate('register', '<=', $request->date_to);
            }

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
                    $download = '
                        <a class="btn btn-xs btn-success btn-download"
                            href="' . route('arc-document.download', $row->id) . '">
                            <i class="fas fa-download"></i>
                        </a>
                    ';

                    return $edit . ' ' . $delete . ' ' . $detail . ' ' . $download;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function create()
    {
        // Code to show form for creating a new inventory category
        $categories = ArcCategory::all();
         return view('arc_documents.form', compact('categories'));
    }

    public function store(Request $request)
    {
        // Code to save a new inventory category
         $request->validate([
        'title'  => 'required',
        'description' => 'required|nullable',
        'register' => 'required|date',
        'status' => 'required|in:pending,approved,rejected,sender',
        'category_id' => 'required|exists:arc_categories,id',
        'type' => 'required|in:incoming,outgoing',
    ]);

     $request->validate([
        'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
    ]);

    $path = $request->file('file')->store('arc_documents', 'public');
    $request->merge(['file_path' => $path]);
    ArcDocument::create($request->all());

    return redirect()
        ->route('arc-document.index')
        ->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        // Code to display a specific inventory category
        $arcDocuments = ArcDocument::findOrFail($id);
        dd($arcDocuments);
    }

    public function edit($id)
    {
        $categories = ArcCategory::all();
        $arcDocument = ArcDocument::findOrFail($id);
        // dd($arcDocuments);
        // Code to show form for editing an inventory category
        return view('arc_documents.form', compact('arcDocument', 'categories'));

    }

    public function update(Request $request, $id)
    {
        // Code to update a specific inventory category
        // dd($request->all());
        $arcDocuments = ArcDocument::findOrFail($id);
         $request->validate([
        'title'  => 'required',
        'description' => 'required|nullable',
        'register' => 'required|date',
        'status' => 'required|in:pending,approved,rejected,sender',
        'category_id' => 'required|exists:arc_categories,id',
        'type' => 'required|in:incoming,outgoing',
        // 'email' => 'required|email',
        // 'phone' => 'nullable',
    ]);

        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);
        // dd($request->file('file'));
        $path = $request->file('file')->store('arc_documents', 'public');
        // dd($path);
        $request->merge(['file_path' => $path]);

        // dd($request->all());
    $arcDocuments->update($request->all());
    dd($request->all());

    return redirect()
        ->route('arc-document.index')
        ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
{
    $category = ArcDocument::findOrFail($id);

    $category->delete();

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil dihapus'
    ]);
}

public function download($id)
{
      $document = ArcDocument::findOrFail($id);

    if (!Storage::disk('public')->exists($document->file_path)) {
        abort(404, 'File tidak ditemukan');
    }

    return Storage::disk('public')->download(
        $document->file_path
    );
}
}
