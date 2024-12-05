<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookBorrowingController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::group(['prefix' => 'authors', 'middleware' => 'auth:api'], function () {
    Route::get('/', [AuthorController::class, 'index']);
    Route::post('/store', [AuthorController::class, 'store']);
    Route::group(['prefix' => '{id}'], function () {
        Route::get('/show', [AuthorController::class, 'show']);
        Route::put('/update', [AuthorController::class, 'update']);
        Route::delete('/destroy', [AuthorController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'books', 'middleware' => 'auth:api'], function () {
    Route::get('/', [BookController::class, 'index']);
    Route::post('/store', [BookController::class, 'store']);
    Route::group(['prefix' => '{id}'], function () {
        Route::get('/show', [BookController::class, 'show']);
        Route::put('/update', [BookController::class, 'update']);
        Route::delete('/destroy', [BookController::class, 'destroy']);
        Route::post('/attach-authors', [BookController::class, 'attachAuthors']);
    });
});

Route::group(['prefix' => 'book-borrowings', 'middleware' => 'auth:api'], function () {
    Route::get('/', [BookBorrowingController::class, 'index']);
    Route::post('/store', [BookBorrowingController::class, 'store']);
});



