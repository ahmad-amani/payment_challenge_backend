<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $userService;
    private $userRepository;

    public function __construct()
    {
        $this->userService = app()->make(UserServiceInterface::class);
        $this->userRepository = app()->make(UserRepositoryInterface::class);
    }

    public function register(Request $request)
    {
        $user = $this->userRepository->create(request()->all());
        return response()->json(["status" => "success", "user" => $user]);
    }

    public function login(Request $request)
    {
        $user = $this->userService->login(request()->all());
        return response()->json(["status" => "success", "user" => $user]);
    }



}
