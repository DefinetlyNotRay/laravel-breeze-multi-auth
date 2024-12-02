<?php

namespace App\Jobs;

use App\Models\Loan;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LockOverdueBooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle()
    {
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
}