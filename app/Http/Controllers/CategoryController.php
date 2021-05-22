<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        return response()->json(Category::all());
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'icon' => 'required',
            'color' => 'required'
        ]);

        return response()->json(Category::create($data), 201);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        $category->save();
        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json($category);
    }
}
