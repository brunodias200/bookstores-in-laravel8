<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenHelper
{
    private $secret;
    private $alg;

    public function __construct()
    {
        $this->secret = env("TOKEN_SECRET", "secret");
        $this->alg = env("TOKEN_ALG", "HS256");
    }

    public function createToken($obj)
    {
        return JWT::encode($obj, $this->secret, $this->alg);
    }
    public function validateToken($token)
    {
        return JWT::decode($token, new Key($this->secret, $this->alg));
    }
}
