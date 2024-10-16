<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index(Request $request){
    
        $category = $request->query('category');
        $categories = Category::all();
        $books = Book::with('category')->get();
        $authors = Book::select('author')->distinct()->get();

        if ($category) {
            // Logic to get books based on the category
            return view('books.index', ['category' => $category,'books'=> $books,"categories"=>$categories,"authors"=>$authors]);
        } else {
            // Logic to get all books
            return view('books.index', ['category' => null,'books'=> $books,"categories"=>$categories,"authors"=>$authors]);
        }
    }

    public function category($category){
        
        return view('books.category', compact('id'));
    }
}