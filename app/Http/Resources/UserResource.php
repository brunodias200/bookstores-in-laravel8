<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private $user;
    public function  __construct($user)
    {
        $this->user = $user;
    }
    public function toArray($request)
    {
        return [
            "id" => $this->user->id,
            "name" => $this->user->name,
            "email" => $this->user->email,
        ];
    }
}
