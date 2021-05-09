<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Laravel\Passport\TokenRepository;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('POS-TOKEN-API')->accessToken;

        $user->save();

//        $account = Account::create([
//            'user_id' => $user->id,
//            'name' => 'Cash',
//            'icon' => 'fas fa-wallet',
//            'currency' => '$',
//            'balance' => '0',
//            'note' => 'Cash Money',
//        ]);

        return response()->json([
            'message' => 'Successfully created user!',
            'user' => $user
        ], 201);
    }

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

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Cannot login with these credentials!'
            ], 404);
        }

        $user = auth()->user();

        $token = $user->createToken('POS API TOKEN');

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        return response()->json([
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
        $tokenRepo = app(TokenRepository::class);

        $tokenRepo->revokeAccessToken(Auth::user()->token()->id);

        Auth::logout();

        return response()->json([
            'message' => 'Successfully logged out!'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return JsonResponse [json] user object
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }
}
