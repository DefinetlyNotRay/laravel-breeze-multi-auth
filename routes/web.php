<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\NoCacheHeaders;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
});
// Route::middleware([NoCacheHeaders::class])->group(function () {
    Route::get('/loan/{id}', [BooksController::class, 'loan'])->name('books.loan');
    Route::get('/books', [BooksController::class,'index']);
    Route::get('/books/{category}', [BooksController::class,'category']);
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/loan/{id}', [BooksController::class, 'loan']);
    Route::middleware(['auth', 'role:user'])->group(function(){
        Route::get('/loans', [LoanController::class,'index']);
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::post('/loans/{id}', [LoanController::class, 'loan'])->name('loans.loan');

    });
// });
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get( '/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post( '/pickedup/{id}', [AdminController::class, 'pickedup']);
    Route::post('/return',[AdminController::class, 'return']);
    Route::get('/admin/books',[AdminController::class, 'books']);
    Route::post('/add/admin/books',[AdminController::class, 'add']);
    Route::delete('/delete/{id}', [AdminController::class, 'delete']);
    Route::post('/edit/admin/books', [AdminController::class, 'edit']);
    Route::get('/admin/loans',[AdminController::class, 'loanPage']);
});;





require __DIR__.'/auth.php';