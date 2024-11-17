<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        $user = Auth::user();
        $book = Book::get();
        $loan = Loan::get();
        return view('admin.dashboard', compact('user', 'book', 'loan'));
    }
}