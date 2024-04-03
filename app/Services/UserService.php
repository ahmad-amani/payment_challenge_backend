<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService implements UserServiceInterface
{

    public function login($data): User
    {

        $validatedData = ValidationService::validate($data, [
            'password' => ['required'],
            'username' => ['required'],
        ]);


        if (Auth::attempt(['username' => $validatedData['username'], 'password' => $validatedData['password']])) {
            $user = Auth::user();
            $user->token = $user->createToken('paystar')->plainTextToken;
            return $user;
        }

        throw new Exception('invalid credintial', 401);

    }

}


?>