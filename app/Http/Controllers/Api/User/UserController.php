<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userService;
    private $userRepository;

    public function __construct()
    {
        $this->userService = app()->make(UserServiceInterface::class);
        $this->userRepository = app()->make(UserRepositoryInterface::class);
    }

    public function update(Request $request)
    {
        $user = $this->userRepository->update(Auth::user(), request()->all());
        return response()->json(["status" => "success", "user" => $user]);
    }



}
