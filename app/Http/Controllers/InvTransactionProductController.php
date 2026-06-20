<?php

namespace App\Http\Controllers;

use App\Models\InvTransactionProduct;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InvTransactionProductController extends Controller
{
    public function index()
    {

        return view('inv_transaction_products.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = InvTransactionProduct::select([
                'id',
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
        // Code to show form for creating a new inventory transaction product
         return view('inv_transaction_products.form');
    }

    public function store(Request $request)
    {
        // Code to save a new inventory transaction product
         $request->validate([
        'name'  => 'required',
        'description' => 'nullable'
    ]);

    InvTransactionProduct::create($request->all());

    return redirect()
        ->route('inv-transaction-product.index')
        ->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        // Code to display a specific inventory transaction product
        $invTransactionProducts = InvTransactionProduct::findOrFail($id);
        dd($invTransactionProducts);
    }

    public function edit($id)
    {
        $invTransactionProducts = InvTransactionProduct::findOrFail($id);
        // dd($invTransactionProducts);
        // Code to show form for editing an inventory transaction product
        return view('inv_transaction_products.form', compact('invTransactionProducts'));

    }

    public function update(Request $request, InvTransactionProduct $invTransactionProducts)
    {
        // Code to update a specific inventory transaction product
         $request->validate([
        'name'  => 'required',
        'description' => 'nullable',
        // 'email' => 'required|email',
        // 'phone' => 'nullable',
    ]);

    $invTransactionProducts->update($request->all());

    return redirect()
        ->route('inv-transaction-product.index')
        ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
{
    $invTransactionProducts = InvTransactionProduct::findOrFail($id);

    $invTransactionProducts->delete();

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil dihapus'
    ]);
}
}
