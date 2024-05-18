<?php

namespace App\Http\Middleware;

use App\Helpers\TokenHelper;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckTokenMiddleware
{
    private $errorMessage;
    private $errorCode;
    private $tokenHelper;

    public function __construct()
    {
        $this->errorMessage = "Invalid Token!";
        $this->errorCode = 401;
        $this->tokenHelper = new TokenHelper;
    }
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->bearerToken();
            if (!$token) {
                return response(['error' => $this->errorMessage], $this->errorCode);
            }

            $decodedToken = $this->tokenHelper->validateToken($token);
            $user = User::find($decodedToken->user->id);

            if (!$user) {
                return response(['error' => $this->errorMessage], $this->errorCode);
            }

            $userToken = $user->loginToken;
            if (!$decodedToken == $userToken) {
                return response(['error' => $this->errorMessage], $this->errorCode);
            }
        } catch (\Exception $e) {
            return response(["error" => $this->errorMessage], $this->errorCode);
        }
        return $next($request);
    }
}
