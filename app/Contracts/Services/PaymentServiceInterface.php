<?php


namespace App\Contracts\Services;

interface PaymentServiceInterface
{
    public function createPayment($data);
    public function verifyPayment($data);
}