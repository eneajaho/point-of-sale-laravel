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
        $users = User::where('deleted', 0)
            ->select('id', 'name', 'email', 'role', 'created_at')
            ->get();
        return response()->json($users);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
//            'password' => 'required|string'
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
//            'password' => bcrypt($request->password),
            'password' => bcrypt('password'),
            'role' => $request->role ? $request->role : 'user'
        ]);

        $user->save();

        return response()->json($user);
    }


    public function show(User $user)
    {
        if ($user->deleted) {
            return response()->json([
                'message' => 'The user has been deleted!'
            ], 404);
        }
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        $user->save();
        return response()->json($user);
    }

    public function delete(User $user)
    {
        $user->deleted = true;
        $user->save();
        return response()->json($user);
    }
}
