<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function create(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $users = User::all();
            return response()->json($request->all(), 200);
        } else {
            return response()->json(Auth::user()->role, 401);
//            return response()->json([
//                'error' => 'Unauthorized!'
//            ], 401);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
