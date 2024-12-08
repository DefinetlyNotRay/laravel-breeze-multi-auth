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
    Route::post('/add/admin/category',[AdminController::class, 'addCategory']);
    Route::delete('/delete/category/{id}',   [AdminController::class, 'deleteCategory']);

    Route::delete('/delete/{id}',  [AdminController::class, 'delete']);
    Route::post('/edit/admin/books', [AdminController::class, 'edit']);
    Route::post('/edit/admin/user', [AdminController::class, 'editUser']);
    Route::delete('/delete/user/{id}', [AdminController::class, 'deleteUser']);

    Route::post('/add/admin/user', [AdminController::class, 'addUser']);

    Route::get('/admin/loans',[AdminController::class, 'loanPage']);
    Route::delete('/edit/admin/category', [AdminController::class, 'editCategory']);
    
    Route::get('/admin/user',[AdminController::class, 'users']);

    Route::get('/admin/kategori',[AdminController::class, 'kategori']);

});;


Route::post('/GetPoints',[AdminController::class, 'getPoints']);

Route::post('/returnBook/{token}', [AdminController::class, 'returnBook'])->where('token', '.*');


require __DIR__.'/auth.php';