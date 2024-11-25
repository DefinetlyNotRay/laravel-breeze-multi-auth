<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Category;
use App\Models\ReturnModel;
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
        $loan = Loan::Loaning()->with('book')->get();
        $loanWait = Loan::Wait()->with('book')->get();

        return view('admin.dashboard', compact('user', 'book', 'loan','loanWait'));
    }
    public function pickedup($id, Request $request)
    {
        $request->validate([
            'selected_date' => 'required|date|after_or_equal:today',
        ]); 

        Loan::where("id_loan", $id)->update([
            "tanggal_tenggat" => $request->selected_date,
            "status" => 'picked up'
        ]);

        return redirect('/admin/dashboard')->with("success", "Due date successfully set.");
    }
    public function return(Request $request)
    {
        $id = $request->loan_id;
        $today = $request->todaysDateInput;
        $kerusakan = $request->kerusakan;
        $denda = $request->denda;

        ReturnModel::create([
            'id_loan' => $id,
            'tanggal_pengembalian' => $today,
            'denda' => $denda,
            "keadaan" => $kerusakan,
        ]);
        Loan::where("id_loan",$id)->update([
            "status" => "returned"
        ]);
        $loansBook = Loan::where("id_loan",$id)->first();
        Book::where("id",$loansBook->id_buku)->update([
            "status" => "Available"
        ]);

        return redirect('/admin/dashboard')->with("success", "Due date successfully set.");
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