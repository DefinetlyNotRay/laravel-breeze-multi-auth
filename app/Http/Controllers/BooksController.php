<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function index(Request $request)
{
    $userId = Auth::id(); // Get the logged-in user's ID

    $category = $request->query('category');
    $categories = Category::all();
    $authors = Book::select('author')->distinct()->get();

    // Get the book IDs the user is currently loaning
    $currentlyLoaningBookIds = Loan::currentlyLoaning($userId)->pluck('id_buku')->toArray();


    // Fetch books with or without a category filter
    $books = Book::with('category')
        ->when($category, function ($query) use ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('nama_category', $category);
            });
        })
        ->get();

    return view('books.index', [
        'category' => $category,
        'books' => $books,
        'categories' => $categories,
        'authors' => $authors,
        'currentlyLoaningBooks' => $currentlyLoaningBookIds,
    ]);
}


    public function category($category){
        
        return view('books.category', compact('id'));
    }
    public function loan($id){
        $userId = Auth::id(); // Get the logged-in user's ID

        $currentlyLoaningBookIds = Loan::currentlyLoaning($userId)->pluck('id_buku')->toArray();

        $books = Book::find($id);
        return view('books.bookPage', [
            
            'books' => $books,
           
            'currentlyLoaningBooks' => $currentlyLoaningBookIds,
        ]);
    }
}