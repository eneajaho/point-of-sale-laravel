<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
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

        $products = $query->paginate($request->pageSize ?? 5);
        return response()->json($products);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'low_stock' => 'required',
            'optimal_stock' => 'required',
            'barcode' => 'required',
            'category_id' => 'required'
        ]);

        $product = Product::create($data);
        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->with(['stock', 'category:id,name'])->first();
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        $product->save();
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json($product, 200);
    }
}
