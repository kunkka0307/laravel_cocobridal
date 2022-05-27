<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PartyService;

class PartyController extends Controller
{
    /**
     * @var PartyService
     */    
    protected $service;

    public function __construct(
        PartyService $service
    )
    {
        $this->service = $service;
    }

    public function getRecentPartys()
    {
        $partys = $this->service->getRecentPartys();
        $topPartys = $this->service->getTopPartys();

        return response()->json(['partys' => $partys, 'top' => $topPartys]);
    }

    public function getDetail($id)
    {
        $party = $this->service->getDetail($id);
        return response()->json(['party' => $party]);
    }

    public function toggleFavorite()
    {
        \DB::beginTransaction();

        try {
            $party = $this->service->getDetail(request()->get('party_id'));
            $user = auth('api')->user();
            if ($user->favorites()->where('party_id', $party->id)->count() > 0) {
                $user->favorites()->detach($party);
            } else {
                $user->favorites()->attach($party);
            }

            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();

            return response()->json(['status' => 'failed']);
        }

        return response()->json(['status' => 'success']);
    }
}
