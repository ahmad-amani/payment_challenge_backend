<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Services\ValidationService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserRepository implements UserRepositoryInterface
{

    public function create($data): User
    {

        $validatedData = ValidationService::validate($data, [
            'password' => ['required'],
            'username' => ['required', 'unique:users'],
        ]);



        $user = (new User())->create([
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
        ]);

        if (!$user)
            throw new \Exception('Failed to create the user!');

        return $user;


    }

    public function update($user, $data): User
    {
        $validatedData = ValidationService::validate($data, [
            'password' => 'min:8',
            'username' => 'unique:users',
            'card' => 'min:16|max:16'
        ]);

        $user->update($validatedData);

        if (!$user)
            throw new \Exception('Failed to create the user!');

        return $user;
    }
}


?>