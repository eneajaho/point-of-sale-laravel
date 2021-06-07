<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('deleted', 0)->where('role', '!=', 'admin')
            ->with(['userShift.shift:id,name'])
            ->select('id', 'name', 'email', 'role', 'created_at')
            ->get();
        return response()->json($users);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
        ]);

        $emailExists = DB::table('users')->where('email', $request->email)->count() >= 1;

        if ($emailExists) {
            return response()->json([
                'error' => 'A user with the same email already exists.'
            ], 401);
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
            'role' => $request->role ?? 'user'
        ]);

        $user->save();

        $userShift = new UserShift();
        $userShift->user_id = $user->id;
        $userShift->shift_id = $request->shift;
        $userShift->save();

        return response()->json($user);
    }

    public function show(User $user)
    {
        if ($user->deleted) {
            return response()->json([
                'message' => 'The user has been deleted!'
            ], 404);
        }

        $user->load('userShift.shift:id,name');
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        $user->save();

        $userShift = UserShift::where('user_id', $user->id)->first();
        $userShift->shift_id = $request->shift;
        $userShift->save();

        return response()->json($user);
    }

    public function setPhoto(Request $request, User $user)
    {
        $path = $request->file('photo')->store('avatars', 'public');
        $user->photo = 'storage/' . $path;
        $user->save();

        return response()->json(['url' =>$user->photo]);
    }

    public function delete(User $user)
    {
        $user->deleted = true;
        $user->save();
        return response()->json($user);
    }
}
