<?php

use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
Schedule::call(function () {
    // Find all overdue loans
    $overdueLoans = Loan::where('tanggal_tenggat', '<', now())
        ->where('status', "loaned")
        ->get();

    foreach ($overdueLoans as $loan) {
        // Mark the loan as returned
        $updated = Loan::where('id_loan', $loan->id_loan)->update(['status' => "returned"]);
        Log::info("Loan ID {$loan->id_loan} has been marked as returned due to overdue. Update successful: {$updated}");
    }
})->everyMinute(); // Adjust frequency as needed
Schedule::call(function () {
    User::increment('points', 20); // Increment points for all users in one query
})->daily();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();