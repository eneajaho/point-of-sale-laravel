<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $users = DB::table('users')
            ->where('deleted', 0)
            ->get();
        return response()->json($users, 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $emailExists = DB::table('users')->where('email', $request->email)->count() >= 1;

        if($emailExists) {
            return response()->json([
                'error' => 'A user with the same email already exists.'
            ], 401);
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ? $request->role : 'user'
        ]);

        $user->save();

        return response()->json($user, 200);
    }


    public function show(User $user)
    {
        return response()->json($user, 200);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        $user->save();
        return response()->json($user, 200);
    }

    public function delete(User $user)
    {
        $user->deleted = true;
        $user->save();
        return response()->json($user, 200);
    }
}
