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
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    
    public function kategori()
    {
        $category = Category::get();

       

        return view('admin.kategori', compact('category'));
    }
    public function dashboard()
    {
        $user = Auth::user();
        $book = Book::orderBy("total_loan", "desc")->get();
        $loan = Loan::Loaning()->with(relations: 'book')->get();
        $countLoan = Loan::loaning()->with('book')->whereDate('tanggal_pinjam', now()->toDateString())->count();        
        $booksReturned = Loan::Returns()->with(relations: 'book')->where('tanggal_tenggat', '=', now())->count();

        return view('admin.dashboard', compact('user', 'book', 'loan','countLoan','booksReturned'));
    }
    public function delete($id)
    {
       
        $book = Book::where('id',$id)->first();
        $book->delete();
        return redirect('/admin/books')->with("success", "Due date successfully set.");

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

    public function addUser(Request $request){
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        //     'password' => ['required', 'confirmed', Password::defaults()],
        // ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/admin/user')->with("success", "User successfully created.");
    }
    public function deleteUser(Request $request ,$id){


        User::where("id", $id)->delete();
        return redirect('/admin/user')->with("success", "User successfully deleted.");
    }
    public function editUser(Request $request){
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        //     'password' => ['required', 'confirmed', Password::defaults()],
        // ]);

        User::where("id", $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/admin/user')->with("success", "User successfully edited.");
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
    public function editCategory(Request $request)
    {
        $id = $request->id;
        $title = $request->title;
       

    
        Category::where("id_category",$id)->update([
            'nama_category' => $title,
           
        ]);

        return redirect('/admin/kategori')->with("success", "Book successfully updated.");
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
          // Store the PDF file
         // Move uploaded PDF to the specified folder
       // Handle the PDF upload
    $pdfName = null; // Initialize variable to store the file name
    if ($request->hasFile('pdf')) {
        $pdf = $request->file('pdf');
        $pdfName = time() . '_' . $pdf->getClientOriginalName(); // Generate unique file name
        $pdf->move(public_path('storage/pdfs'), $pdfName); // Move to `public/storage/pdfs`
    }
        Book::create([
            'title' => $title,
            'author' => $author,
            'id_category' => $categoryId,
            'desc' => $desc,
            "cover_img" => $cover,
            "pdf"=>$pdfName
            
        ]);


        return redirect('/admin/books')->with("success", "Due date successfully set.");

        
    }   
    
    public function deleteCategory($id)
    {   
       
        
        Category::where("id_category", $id)->delete();
    
    
        return redirect('/admin/kategori')->with("success", "Book successfully updated.");
    }
    public function addCategory(Request $request)
    {   
        $title = $request->title;
       
        
        Category::create([
            'nama_category' => $title,
           
            
        ]);


        return redirect('/admin/kategory')->with("success", "Book successfully updated.");
    }
    
}