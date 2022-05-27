<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Models\Book;

class PaymentService
{
    public function refundPayment($book)
    {
        $canCancelDate = Carbon::now()->addDays(intval(config('values.book_cancel_days')))->format("Y-m-d 23:59:59");
        $canCancelDate = Carbon::parse($canCancelDate);

        if (isset($book->party->open_at) && $book->party->open_at->gt($canCancelDate)) {
            // Stripe Refund Process
    
            // Save Refund Amount
            $book->payments()->create([
                'user_id'       => $book->user_id,
                'party_id'      => $book->party_id,
                'amount'        => 0 - $book->amount
            ]);
        }

        return true;
    }

    public function pay($amount)
    {
        return true;
    }
}