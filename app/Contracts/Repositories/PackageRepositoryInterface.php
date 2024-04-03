<?php


namespace App\Contracts\Repositories;

interface PackageRepositoryInterface
{
    public function index();
    public function findOrFail(int $id);

}