<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => ['login', 'register']]);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->toJson()
            ], 400);
        }
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 400,
                'message' => json_encode(["email" => 'Tài khoản không tồn tại.'])
            ], 400);
        }

        return $this->respondWithToken($token);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:4|string|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->toJson()
            ], 400);
        }
        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => Hash::make($request->password), "role" => "user"]
        ));
        return response()->json([
            'status' => 200,
            'message' => 'Tạo tài khoản thành công.',
        ]);
    }


    public function me()
    {
        return response()->json(['user' => auth()->user()]);
    }


    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 200,
            'message' => 'Đăng xuất thành công.'
        ]);
    }


    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 200,
            'user' => [
                'token' => $token,
                'id' => auth()->user()->_id,
                'name' => auth()->user()->name,
                'role' => auth()->user()->role
            ]
        ]);
    }
}
