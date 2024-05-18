<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    private $store;
    public function  __construct($store)
    {
        $this->store = $store;
    }
    public function toArray($request)
    {
        return [
            "id" => $this->store->id,
            "name" => $this->store->name,
            "address" => $this->store->address,
            "active" => $this->store->active,
        ];
    }
}
