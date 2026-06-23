<?php

namespace App\Http\Controllers;

use App\Models\InvProduct;
use App\Models\InvTransaction;
use App\Models\InvTransactionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'code',
                'note',
                'status',
                'created_at',
                'updated_at',
                'register',
                'due_time',
            ])->with("products");

            return DataTables::of($query)

            ->addColumn('products', function ($row) {

        return $row->products
            ->map(function ($product) {

                return '<span class="badge badge-info mr-1">'
                    .$product->name
                    .' x '
                    .$product->pivot->quantity
                    .'</span>';

            })
            ->implode(' ');
    })

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

                ->rawColumns(['action','products'])
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
            'transaction_date' => 'required|date',
            'transaction_type' => 'required',

            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:inv_products,id',

            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
        ]);

    DB::transaction(function () use ($request) {

        $transaction = InvTransaction::create([
            'code' => 'TRX-' . time(),
            'register' => $request->transaction_date,
            'status' => 'pending',
            'transaction_type' => $request->transaction_type,
            'note' => $request->note,
        ]);

        foreach ($request->product_id as $index => $productId) {

            $transaction->invTransactionProducts()->create([
                'product_id' => $productId,
                'quantity' => $request->quantity[$index],
            ]);
        }
    });

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
        $invTransaction = InvTransaction::with([
        'invTransactionProducts.product'
        ])->findOrFail($id);

        $products = InvProduct::orderBy('created_at', 'desc')->get();

        return view(
            'inv_transactions.form',
            compact('invTransaction', 'products')
        );

        }

   public function update(Request $request, $id)
{
$request->validate([
'register' => 'required|date',
'transaction_type' => 'required',

    'product_id' => 'required|array|min:1',
    'product_id.*' => 'required|exists:inv_products,id',

    'quantity' => 'required|array|min:1',
    'quantity.*' => 'required|integer|min:1',
]);

DB::transaction(function () use ($request, $id) {

    $transaction = InvTransaction::findOrFail($id);

    $transaction->update([
        'register' => $request->register,
        'transaction_type' => $request->transaction_type,
        'note' => $request->note,
    ]);

   $syncData = [];

foreach ($request->product_id as $index => $productId) {

    $syncData[$productId] = [
        'quantity' => $request->quantity[$index]
    ];
}

$transaction->products()->sync($syncData);

});

return redirect()
    ->route('inv-transaction.index')
    ->with('success', 'Transaksi berhasil diperbarui');

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
