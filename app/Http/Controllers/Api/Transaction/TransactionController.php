<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Contracts\Repositories\TransactionRepositoryInterface;
use App\Contracts\Services\PaymentServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{



    public function index(TransactionRepositoryInterface $transactionRepository)
    {
        $transactions = $transactionRepository->userRecent(Auth::id());
        return response()->json(['status' => 'success', 'transactions' => $transactions]);
    }




}
