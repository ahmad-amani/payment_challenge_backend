<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Contracts\Repositories\TransactionRepositoryInterface;
use App\Contracts\Services\PaymentServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function __construct()
    {
    }

    public function purchase(PaymentServiceInterface $paymentService, Request $request)
    {
        $paymentLink = $paymentService->createPayment($request->all());
        return response()->json(['status' => 'success', 'payment_link' => $paymentLink]);
    }


    public function verify(PaymentServiceInterface $paymentService, Request $request)
    {
        $paymentService->verifyPayment($request->all());
        return response()->redirectTo(env('FRONTEND_TRANSACTION_URL'));
    }



}
