<?php

namespace App\Repositories;

use App\Contracts\Repositories\TransactionRepositoryInterface;
use App\Models\Transaction;
use App\Services\ValidationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TransactionRepository implements TransactionRepositoryInterface
{

    public function create($data)
    {
        $validateData = ValidationService::validate($data, [
            'card' => 'min:16|max:16',
            'price' => ['required', 'numeric', 'gte:5000', 'lte:500000000'],
            'package_id' => ['required'],
            'user_id' => ['required']
        ]);

        $transaction = (new Transaction())->create($validateData);

        if (!$transaction)
            throw new \Exception('Failed to create the transaction!');

        return $transaction;
    }

    public function update($id, $data)
    {
        $validatedData = ValidationService::validate($data, [
            'ref' => 'string|max:20',
            'status' => '',
            'paid_at' => '',
            'message' => ''
        ]);
        $transaction = $this->find($id);
        $update = $transaction->update($validatedData);

        if (!$update)
            throw new \Exception('Failed to update the transaction!');

        return $transaction;
    }
    public function find($id)
    {
        return Transaction::findOrFail($id);
    }

    public function userRecent($user_id)
    {
        return Transaction::where('user_id', '=', $user_id)->with('package')->orderBy('id', 'desc')->limit(10)->get();
    }



}


?>