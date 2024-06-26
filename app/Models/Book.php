<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';

    protected $fillable = [
        'name',
        'isbn',
        'value',
    ];
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'books_stores',  'book_id', 'store_id');
    }
}
