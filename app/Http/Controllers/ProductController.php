<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
//        $products = DB::table('products')->paginate('15');
//        $users = DB::table('users')->skip(10)->take(5)->get();

        $query = Product::with('stock', 'category');


//        $queryBuilder = DB::table('subscribers')->select('id', 'name', 'email');
//        if ($request->has('search')) {
//            $queryBuilder = $queryBuilder->Where('email', 'like', '%' . $request['search'] . '%')
//                ->orWhere('name', 'like', '%' . $request['search'] . '%');
//        }
//        if ($request->has('orderby')) {
//            $sort = $request->has('sort') ? $request['sort'] : 'asc';
//            $queryBuilder = $queryBuilder->orderBy($request['orderby'], $sort);
//        }
//        $this->subscribers = $queryBuilder->paginate(20);
////        $subscribers->cnt = $cnt;
//
//        if ($request->has('search')) {
//            $this->subscribers->appends(['search' => $request['search']]);
//        }
//        if ($request->has('orderby')) {
//            $this->subscribers->appends(['orderby' => $request['orderby']]);
//            $this->subscribers->appends(['sort' => $sort]);
//        }
//        return view('subscriber.index', ['subscribers'=>$this->subscribers]);

//        $products = Product::with('category', 'stock')->paginate(2);
        $products = $query->simplePaginate($request->pageSize ?? 5);
        return response()->json($products, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
