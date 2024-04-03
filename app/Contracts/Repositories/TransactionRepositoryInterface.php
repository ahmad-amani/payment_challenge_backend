<?php


namespace App\Contracts\Repositories;

interface TransactionRepositoryInterface
{
    public function create($data);
    public function update($id, $data);

    public function find($id);
    public function userRecent($user_id);
}