<?php

namespace App\Http\Controllers\Api\Package;

use App\Contracts\Repositories\PackageRepositoryInterface;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    public function __construct()
    {
    }

    public function index(PackageRepositoryInterface $packageRepository)
    {
        $packages = $packageRepository->index();
        return response(['status' => 'success', 'packages' => $packages]);
    }



}
