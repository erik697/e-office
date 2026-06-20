<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Product $products){
        return view('products.index', ['produks'=>$products]);
    }
    public function create(Request $request){
        return view('products.index');
    }
    public function store(Request $request){
        $validated = $request->validate([

            'name' => 'required',
            'code' => 'required|unique:letter_categories,code',
            'description' => 'nullable',

        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Data berhasil ditambahkan');
    }
}
