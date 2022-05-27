<?php

namespace App\Services;
use App\Models\Party;
use Illuminate\Support\Arr;
use Carbon\Carbon;


class PartyService
{
    public function getRecentPartys()
    {
        $query = Party::query();

        $query = $query->where('open_date', '>=', Carbon::now()->format('Y-m-d'))
                       ->where('open_date', '<=', Carbon::now()->addDay(7)->format('Y-m-d')) 
                       ->with('room');

        return $query->get();
    }

    public function getTopPartys()
    {
        $query = Party::query();

        $query = $query->where('open_date', '>=', Carbon::now()->format('Y-m-d'))
                       ->where('open_date', '<=', Carbon::now()->addDay(7)->format('Y-m-d'))
                       ->with('room')
                       ->orderByDesc('open_date')
                       ->orderByDesc('open_time');

        return $query->limit(4)->get();
    }

    public function getDetail($id) {
        return Party::where('id', $id)
                    ->with('room')
                    ->with('books')
                    ->with('room.images')
                    ->with('tags')
                    ->first();
    }
}