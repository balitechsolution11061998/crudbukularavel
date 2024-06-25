<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');



Route::get('/books', [App\Http\Controllers\Api\BookController::class, 'data'])->name('data.books');
Route::get('/books/{id}', [App\Http\Controllers\Api\BookController::class, 'show'])->name('data.books.show');
Route::post('/books/store', [App\Http\Controllers\Api\BookController::class, 'storeOrUpdate'])->name('books.store');
Route::delete('/books/destroy/{id}', [App\Http\Controllers\Api\BookController::class, 'destroy'])->name('books.destroy');



