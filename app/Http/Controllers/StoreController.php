<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\StoreRequest;
use App\Http\Resources\StoreResourceWithBooks;
use App\Models\Book;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    function getStores(Request $request)
    {


        $stores = Store::query();
        $stores = $request->name ? $stores->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->name) . '%']) : $stores;
        $stores = $request->address ? $stores->whereRaw('LOWER(address) LIKE ?', ['%' . strtolower($request->address) . '%']) : $stores;
        $stores = $request->active ? $stores->where('active', strtoupper($request->active) == "TRUE" ? 1 : 0) : $stores;

        return response(StoreResourceWithBooks::collection($stores->get()));
    }
    function getStoreById($id)
    {
        if (!is_numeric($id)) {
            return response(['error' => "Id should be numeric"], 400);
        }
        $store = Store::find($id);

        return response(new StoreResourceWithBooks($store));
    }
    function createStore(StoreRequest $request)
    {
        return response(Store::create($request->all()), 201);
    }
    function updateStore(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(['error' => "Id should be numeric"], 400);
        }
        $store = Store::find($id);
        if (!$store) {
            return response(['error' => "Store not found"], 404);
        }
        $store->update($request->all());

        return response(new StoreResourceWithBooks($store), 200);
    }
    function deleteStore($id)
    {
        if (!is_numeric($id)) {
            return response(['error' => "Id should be numeric"], 400);
        }
        $store = Store::find($id);
        if (!$store) {
            return response(['error' => "Store not found"], 404);
        }

        $store->delete();
        return response([
            "message" => "Successfully deleted store with id: $id!",
        ]);
    }
    function includeBookInStore(BookStoreRequest $request)
    {
        $store = Store::find($request->store_id);
        $book = Book::find($request->book_id);
        if (!$book || !$store) {
            return response(['error' => "Store and/or book not found"], 404);
        }

        $store->books()->syncWithoutDetaching($book);
        return response([
            "message" => "Successfully added book ($request->book_id) to store ($request->store_id)!",
            "store" => new StoreResourceWithBooks($store)
        ]);
    }
    function deleteBookFromStore(BookStoreRequest $request)
    {
        $store = Store::find($request->store_id);
        $book = Book::find($request->book_id);
        if (!$book || !$store) {
            return response(['error' => "Store and/or book not found"], 404);
        }

        $store->books()->detach($book);
        return response([
            "message" => "Successfully removed book ($request->book_id) from store ($request->store_id)!",
            "store" => new StoreResourceWithBooks($store)
        ]);
    }
}
