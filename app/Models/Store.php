<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';

    protected $fillable = [
        'name',
        'address',
        'active',
    ];
    public function books()
    {
        return $this->belongsToMany(Book::class, 'books_stores', 'store_id', 'book_id');
    }
}
