<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index(Request $request){
    
        $category = $request->query('category');
        $books = Book::all();
        if ($category) {
            // Logic to get books based on the category
            return view('books.index', ['category' => $category,'books'=> $books]);
        } else {
            // Logic to get all books
            return view('books.index', ['category' => null,'books'=> $books]);
        }
    }

    public function category($category){
        
        return view('books.category', compact('id'));
    }
}