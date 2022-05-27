<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReservationService;
use App\Services\PaymentService;

class ReservationController extends Controller
{
    /**
     * @var ReservationService
     */    
    protected $service;

    protected $paymentService;

    public function __construct(
        ReservationService $service,
        PaymentService $paymentService
    )
    {
        $this->service = $service;
        $this->paymentService = $paymentService;
    }

    public function reserve()
    {
        \DB::beginTransaction();

        try {
            $payResult = $this->paymentService->pay(request()->get('amount'));
            if ($payResult == true) {
                $this->service->reserve(request()->get('party_id'), request()->get('friends'),   request()->get('amount'));
            } else {
                return response()->json(['status' => 'payment_failed']);
            }

            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();

            return response()->json(['status' => 'failed']);
        }

        return response()->json(['status' => 'success']);
    }

    public function books()
    {
        return response()->json(['parties' => auth('api')->user()->active_parties]);
    }

    public function cancelReservation()
    {
        \DB::beginTransaction();

        try {
            $book = auth('api')->user()->active_books()->where('party_id', request()->get('party_id'))->first();
            if (is_null($book)) return response()->json(['status' => 'failed']);

            $result = $this->paymentService->refundPayment($book);
            if ($result == true) {
                $this->service->cancelBook($book);
            }

            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());

            return response()->json(['status' => 'failed']);
        }

        return response()->json(['status' => 'success', 'parties' => auth('api')->user()->active_parties]);
    }
}
