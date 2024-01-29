<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReaderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('books', BookController::class)->except('show');

Route::get('/books/{book}/assign', [BookController::class, 'showAssignPage'])->name('books.showAssign');
Route::post('/books/{book}/assign', [BookController::class, 'assignBookToReader'])->name('books.assign');
Route::post('/books/{book}/return', [BookController::class, 'returnBook'])->name('books.return');

Route::resource('readers', ReaderController::class)->except('show');