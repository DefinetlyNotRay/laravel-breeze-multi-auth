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
    public function returnPage($id)
    {


        $loan = Loan::where("id_loan", $id)->get();

        return view('admin.returnPage',compact('loan'))->with("success", "Due date successfully set.");
    }
}