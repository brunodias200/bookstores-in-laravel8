<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResourceWithStores;
use App\Models\Book;

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
    public function createBook(BookRequest $request,)
    {
        return response(Book::create($request->all()), 201);
    }
    public function updateBook(BookRequest $request, $id)
    {
        if (!is_numeric($id)) {
            return response(['error' => "Id should be numeric"], 400);
        }
        $book = Book::find($id);
        if (!$book) {
            return response(['error' => "Book not found"], 404);
        }
        $book->update($request->all());

        return response(new BookResourceWithStores($book), 200);
    }
    public function deleteBook($id)
    {
        if (!is_numeric($id)) {
            return response(['error' => "Id should be numeric"], 400);
        }
        $book = Book::find($id);
        if (!$book) {
            return response(['error' => "Book not found"], 404);
        }

        $book->delete();
        return response([
            "message" => "Successfully deleted book with id: $id!",
        ]);
    }
}
