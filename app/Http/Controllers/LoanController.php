<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index(){ 
        $userId = Auth::user(); // Current logged-in user

        // Get loans based on their status
        $currentlyLoaning = Loan::currentlyLoaning(userId: $userId->id)->with('book')->get();
        $pastLoans = Loan::returned(userId: $userId->id)->with('book')->get();

    
        return view('user.loan', compact('currentlyLoaning','pastLoans'));
    }
    public function loan(Request $request){ 
        $user = Auth::user();
        $bookId = $request->id_buku; // Correctly named input for the book ID
        $dueDateDays = (int) $request->due_date_days; // Explicitly cast to integer
    
        // Validate the request data
      
       

        $dueDate = now()->addDays($dueDateDays);
        $book = Book::find($bookId);
        $pointsCase = 0;
        switch ($dueDateDays) {
            case 3:
                $pointsCase = 5;
                break;
            case 7:
                $pointsCase = 10;
                break;
            case 14:
                $pointsCase = 20;
                break;
            default:
                $pointsCase = 0; // Default case if no match
                break;
        }
    

        if ($book) {
            // Check if total_loan is null
            if ($book->total_loan === null) {
                $book->update(['total_loan' => 1]);
            } else {
                // Increment the total_loan value by 1
                $book->update(['total_loan' => $book->total_loan + 1]);
            }
        } else {
            // Handle case where book is not found
            return response()->json(['error' => 'Book not found'], 404);
        }
        
        $user = User::find($user->id);
        if ($user) {
            // Deduct points from the user
            if ($user->points >= $pointsCase) {
                $user->decrement('points', $pointsCase);
            } else {
                return redirect("/books")->withMessage('Not Enough Points !');
            }
        } else {
            // Handle unauthenticated user
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        Loan::create([
            'id_user' => $user->id,
            'id_buku' => $bookId,
            'tanggal_pinjam' => date('Y-m-d'),
            "tanggal_tenggat" => $dueDate->format('Y-m-d'),
            "status" => "loaned"
        ]);
        return redirect("/books")->withMessage('Loan done successfully !');
    }
}