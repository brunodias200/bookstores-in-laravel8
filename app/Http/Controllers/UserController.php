<?php

namespace App\Http\Controllers;

use App\Helpers\TokenHelper;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $userData = $request->all();
        $userData['password'] = Hash::make($userData['password']);

        if (User::where('email', $request->email)->first()) {
            return response(['error' => "Email already in use!"], 400);
        }

        return response(new UserResource(User::create($userData)), 201);
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

        $user->update(['loginToken' => $token]);
        return response([
            "message" => "User successfully logged in",
            "user" => new UserResource($user),
            "token" => $token,
        ]);
    }
}
