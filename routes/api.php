<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckTokenMiddleware;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [UserController::class, 'login']);

Route::prefix('user')->group(function () {
    Route::post('/', [UserController::class, 'register']);
});

Route::middleware(CheckTokenMiddleware::class)->group(function () {
    Route::prefix('book')->group(function () {
        Route::get('/', [BookController::class, 'getBooks']);
        Route::get('/{id}', [BookController::class, 'getBookById']);
        Route::post('/', [BookController::class, 'createBook']);
        Route::put('/{id}', [BookController::class, 'updateBook']);
        Route::delete('/{id}', [BookController::class, 'deleteBook']);
    });

    Route::prefix('store')->group(function () {
        Route::get('/', [StoreController::class, 'getStores']);
        Route::get('/{id}', [StoreController::class, 'getStoreById']);
        Route::post('/', [StoreController::class, 'createStore']);
        Route::put('/{id}', [StoreController::class, 'updateStore']);
        Route::delete('/{id}', [StoreController::class, 'deleteStore']);
    });

    Route::prefix('book_store')->group(function () {
        Route::post('/', [StoreController::class, 'includeBookInStore']);
        Route::delete('/', [StoreController::class, 'deleteBookFromStore']);
    });
});
