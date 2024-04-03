<?php


namespace App\Contracts\Repositories;

interface UserRepositoryInterface
{
    public function create($data);
    public function update($user, $data);
}