<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreResourceWithBooks;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    function getStores()
    {
        $res = [];
        $stores = Store::all();

        foreach ($stores as $store) {
            $res[] = new StoreResourceWithBooks($store);
        }
        return response($res);
    }
    function getStoreById($id)
    {
        if (!is_numeric($id)) {
            return response(['error' => "Id should be numeric"], 400);
        }
        $store = Store::find($id);

        return response(new StoreResourceWithBooks($store));
    }
    function createStore(Request $request)
    {
        return 'createStore not implemented yet!';
    }
    function updateStore(Request $request, $id)
    {
        return 'updateStore not implemented yet!';
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
    function includeBookInStore(Request $request)
    {
        return 'includeBookInStore not implemented yet!';
    }
    function deleteBookFromStore(Request $request)
    {
        return 'deleteBookFromStore not implemented yet!';
    }
}
