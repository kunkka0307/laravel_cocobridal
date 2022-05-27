<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Models\Party;
use App\Enums\BookStatus;

class ReservationService
{
    public function reserve($partyId, $friends, $amount)
    {
        $book = Book::create([
            'user_id'   => auth('api')->user()->id,
            'party_id'  => $partyId,
            'status'    => BookStatus::RESERVED,
            'amount'    => $amount,
            'friend'    => sizeof($friends),
            'friend_info' => json_encode($friends)
        ]);

        $book->payments()->create([
            'user_id'       => auth('api')->user()->id,
            'party_id'      => $partyId,
            'amount'        => $amount
        ]);

        return true;
    }

    public function getReservation($id)
    {
        return Book::find($id);
    }

    public function cancelBook($book)
    {
        return $book->update(['status' => BookStatus::CANCEL]);
    }
}