<?php

namespace App\Http\Controllers;

use App\Models\InvProduct;
use App\Models\InvTransaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InvTransactionController extends Controller
{
       public function index()
    {

        return view('inv_transactions.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = InvTransaction::select([
                'id',
                'type',
                'status',
            ])->with([['invTransactionProducts' => function ($query) {
                $query->with(['product']);
            }]]);

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
        // Code to show form for creating a new inventory transaction
        $products = InvProduct::all();
         return view('inv_transactions.form', compact('products'));
    }

    public function store(Request $request)
    {
        // Code to save a new inventory transaction
         $request->validate([
        'name'  => 'required',
        'description' => 'nullable'
    ]);

    InvTransaction::create($request->all());

    return redirect()
        ->route('inv-transaction.index')
        ->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        // Code to display a specific inventory transaction
        $invTransactions = InvTransaction::findOrFail($id);
        dd($invTransactions);
    }

    public function edit($id)
    {
        $products = InvProduct::all();
        $invTransactions = InvTransaction::findOrFail($id);
        // dd($invTransactions);
        // Code to show form for editing an inventory transaction
        return view('inv_transactions.form', compact('invTransactions', 'products'));
    }

    public function update(Request $request, InvTransaction $invTransactions)
    {
        // Code to update a specific inventory transaction
         $request->validate([
        'name'  => 'required',
        'description' => 'nullable',
        // 'email' => 'required|email',
        // 'phone' => 'nullable',
    ]);

    $invTransactions->update($request->all());

    return redirect()
        ->route('inv-transaction.index')
        ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
{
    $invTramsactionsProducts = InvTransaction::findOrFail($id);
    $invTramsactionsProducts->delete();
    $invTransactions = InvTransaction::findOrFail($id);

    $invTransactions->delete();

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil dihapus'
    ]);
}
}
