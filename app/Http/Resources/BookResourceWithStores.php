<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResourceWithStores extends JsonResource
{
    private $book;
    public function  __construct($book)
    {
        $this->book = $book;
    }
    public function toArray($request)
    {
        return [
            'id' => $this->book->id,
            'name' => $this->book->name,
            'isbn' => $this->book->isbn,
            'value' => $this->book->value,
            'stores' => StoreResource::collection($this->book->stores)
        ];
    }
}
