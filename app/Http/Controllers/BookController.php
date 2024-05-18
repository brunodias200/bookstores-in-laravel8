<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResourceWithStores;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function getBooks()
    {
        $res = [];
        $books = Book::all();

        foreach ($books as $book) {
            $res[] = new BookResourceWithStores($book);
        }
        return response($res);
    }
    public function getBookById($id)
    {
        if (!is_numeric($id)) {
            return response(['error' => "Id should be numeric"], 400);
        }
        $book = Book::find($id);

        return response(new BookResourceWithStores($book));
    }
    public function createBook(Request $request,)
    {
        return 'createBook not implemented yet!';
    }
    public function updateBook(Request $request, $id)
    {
        return 'updateBook not implemented yet!';
    }
    public function deleteBook($id)
    {
        return 'deleteBook not implemented yet!';
    }
}
