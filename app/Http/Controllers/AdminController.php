<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Models\Category;
use App\Models\ReturnModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $loan = Loan::Loaning()->with('book')->get();
        $loanWait = Loan::Wait()->with('book')->get();

        return view('admin.dashboard', compact('user', 'book', 'loan','loanWait'));
    }

    public function returnBook(){
         // Find all overdue loans
         $overdueLoans = Loan::where('tanggal_tenggat', '<', now())
         ->where('status', "loaned")
         ->get();

     foreach ($overdueLoans as $loan) {
         // Mark the loan as returned
         $loan->update(['status' => "returned"]);

         // Log the action
         Log::info("Loan ID {$loan->id} has been marked as returned due to overdue.");
     }
    }

    public function loanPage()
    {
        $loans = Loan::get();

       

        return view('admin.loans', compact('loans'));
    }
    public function users()
    {
        $users = User::get();
        return view('admin.user', compact('users'));
    }
   
    public function edit(Request $request)
    {
        $id = $request->id;
        $title = $request->title;
        $desc = $request->desc;
        $author = $request->author;
        $cover = $request->uploadedImageUrl;

        if ($request->has('newCategory') && $request->input('newCategory') !== null) {
            $category = Category::create([
                'nama_category' => $request->newCategory,
            ]);
            $categoryId = $category->id_category;
        } else {
            $categoryId = $request->Category;
        }

        Book::where("id",$id)->update([
            'title' => $title,
            'author' => $author,
            'id_category' => $categoryId,
            'desc' => $desc,
            "cover_img" => $cover
        ]);

        return redirect('/admin/books')->with("success", "Book successfully updated.");
    }
    public function books(Request $request)
    {
        $category = $request->query('category');
        $categories = Category::all();
        $authors = Book::select('author')->distinct()->get();
    
        $books = Book::get();
    
        return view('admin.books', [
            'category' => $category,
            'books' => $books,
            'categories' => $categories,
            'authors' => $authors
        ]);
    }
    public function add(Request $request)
    {   
        $title = $request->title;
        $desc = $request->desc;
        $author = $request->author;
        $cover = $request->uploadedImageUrl;
          // Check if a new category needs to be created
          if ($request->has('newCategory') && $request->input('newCategory') !== null) {
            $category = Category::create([
                'nama_category' => $request->newCategory,
            ]);
            $categoryId = $category->id_category;
        } else {
            $categoryId = $request->Category;
        }
        Book::create([
            'title' => $title,
            'author' => $author,
            'id_category' => $categoryId,
            'status' => "Available",
            'desc' => $desc,
            "cover_img" => $cover
            
        ]);


        return redirect('/admin/books')->with("success", "Due date successfully set.");
    }
    
}