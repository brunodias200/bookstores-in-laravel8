<?php

namespace App\Http\Controllers;

use App\Helpers\TokenHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $userData = $request->all();
        $userData['password'] = Hash::make($userData['password']);
        return response(User::create($userData), 201);
    }

    public function login(Request $request)
    {
        $tokenHelper = new TokenHelper;

        $invalidLoginReturn = response(['error' => "Incorrect email and/or password"], 401);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $invalidLoginReturn;
        }
        if (!Hash::check($request->password, $user->password)) {
            return $invalidLoginReturn;
        }
        $token = $tokenHelper->createToken([
            "ip" => '',
            "user" => $user
        ]);
        return response([
            "message" => "User successfully logged in",
            "token" => $token,
            "user" => $user
        ]);
    }
}
