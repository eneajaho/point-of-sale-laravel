<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login user and create token
     *
     * @param Request $request
     * @return JsonResponse [string] access_token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Cannot login with these credentials!'
            ], 401);
        }

        $user = auth()->user();

        $token = $user->createToken('POS API TOKEN');

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        return response()->json([
            'name' => $user->name,
            'role' => $user->role,
            'userId' => $user->id,
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $token->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return JsonResponse [string] message
     */
    public function logout()
    {
//        $tokenRepo = app(TokenRepository::class);

//        $tokenRepo->revokeAccessToken(Auth::user()->token()->id);

        Auth::logout();

        Auth::user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out!'
        ]);
    }

    public function adminExists()
    {
        $admin_exists = User::where('role', 'admin')->count() > 0;

        if ($admin_exists) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function createAdmin(Request $request)
    {
        $admin_exists = User::where('role', 'admin')->count() > 0;

        if ($admin_exists) {
            return response()->json([
                'message' => 'An Admin account exists, so you cannot create another one!'
            ], 401);
        }

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'name' => 'Admin',
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin'
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created admin!'
        ], 201);
    }

    public function changeName(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->save();
        return response()->json($user);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'newPassword' => 'required|string'
        ]);

        if(!Hash::check($request->oldPassword, Auth::user()->password)) {
            return response()->json([
                'message' => 'Old password is not correct!'
            ], 401);
        }

        $user = Auth::user();
        $user->password = bcrypt($request->newPassword);
        $user->save();
        return response()->json($user);
    }

    /**
     * Get the authenticated User
     *
     * @return JsonResponse [json] user object
     */
    public function details()
    {
        return response()->json(Auth::user());
    }
}
