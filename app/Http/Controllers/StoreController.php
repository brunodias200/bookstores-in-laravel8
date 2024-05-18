<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    function getStores()
    {
        $res = [];
        $stores = Store::all();

        foreach ($stores as $store) {
            $res[] = new StoreResource($store);
        }
        return response($res);
    }
    function getStoreById($id)
    {
        if (!is_numeric($id)) {
            return response(['error' => "Id should be numeric"], 400);
        }
        $store = Store::find($id);

        return response(new StoreResource($store));
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
        return 'deleteStore not implemented yet!';
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