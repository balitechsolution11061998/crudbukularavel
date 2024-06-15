<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;


Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login');

    Route::get('/books/datas', [BookController::class, 'data'])->name('books.datas');

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [BookController::class, 'index']);
    Route::get('/books/data', [BookController::class, 'data'])->name('books.data');
    Route::post('/books/store', [BookController::class, 'storeOrUpdate'])->name('books.store');
    Route::delete('/books/destroy', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/books/{id}', [BookController::class, 'edit'])->name('books.edit');

    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});
