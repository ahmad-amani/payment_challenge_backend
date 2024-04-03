<?php

namespace App\Repositories;

use App\Contracts\Repositories\PackageRepositoryInterface;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PackageRepository implements PackageRepositoryInterface
{
    public function index(): Collection
    {
        return Package::all();
    }

    public function findOrFail(int $id): Package
    {
        return Package::findOrFail($id);
    }
}


?>