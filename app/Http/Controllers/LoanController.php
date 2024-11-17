<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index(){ 
        $userId = Auth::user(); // Current logged-in user

        // Get loans based on their status
        $currentlyLoaning = Loan::currentlyLoaning($userId->id)->with('book')->get();
        $returnedBooks = Loan::returned($userId->id)->with('book')->get();
        $waitingToBePickedUp = Loan::waitingToBePickedUp($userId->id)->with('book')->get();
    
        return view('user.loan', compact('currentlyLoaning', 'returnedBooks', 'waitingToBePickedUp'));
    }
    public function loan(Request $request, $id){ 
        $user = Auth::user();
         // Check if the user already has 3 or more books loaned
        $currentLoans = Loan::where('id_user', $user->id)
        ->whereIn('status', ['reserved', 'picked up']) // Active loan statuses
        ->count();

        if ($currentLoans >= 3) {
            return redirect("/books")->withErrors('You cannot borrow more than 3 books at a time.');
        }
        Loan::create([
            'id_user' => $user->id,
            'id_buku' => $id,
            'tanggal_pinjam' => date('Y-m-d'),
            "tanggal_tenggat" => "00-00-0000",
            'status' => "reserved"
        ]);
        Book::where('id', $id)->update(['status' => 'Unavailable']);
        return redirect("/books")->withMessage('Loan successfully requested!');
    }
}