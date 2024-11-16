<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index(Request $request)
{
    $category = $request->query('category');
    $categories = Category::all();
    $authors = Book::select('author')->distinct()->get();

    // Ambil buku berdasarkan kategori atau semua buku
    if ($category) {
        $books = Book::with('category')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('nama_category', $category);
            })
            ->orderByRaw("
                CASE 
                    WHEN status = 'Available' THEN 1
                    WHEN status = 'Unavailable' THEN 2
                    ELSE 3
                END
            ")
            ->get();
    } else {
        $books = Book::with('category')
            ->orderByRaw("
                CASE 
                    WHEN status = 'Available' THEN 1
                    WHEN status = 'Unavailable' THEN 2
                    ELSE 3
                END
            ")
            ->get();
    }

    return view('books.index', [
        'category' => $category,
        'books' => $books,
        'categories' => $categories,
        'authors' => $authors
    ]);
}


    public function category($category){
        
        return view('books.category', compact('id'));
    }
    public function loan($id){
        $books = Book::find($id);
        return view('books.bookPage', compact('books'));
    }
}