<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::with(['stock', 'category:id,name']);

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('barcode')) {
            $query->where('barcode', 'like', '%' . $request->barcode . '%');
        }

        if ($request->has('hasLowStock')) {
            $query->whereHas('stock', function ($q) {
                $q->whereColumn('quantity', '<=', 'products.low_stock');
            });
        }

        if ($request->has('categoryId')) {
            $query->where('category_id', $request->categoryId);
        }

        $products = $query->simplePaginate($request->pageSize ?? 5);
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::with(['stock', 'category:id,name'])->get();

        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
