<?php

namespace App\Services;

use App\Contracts\Repositories\PackageRepositoryInterface;
use App\Contracts\Repositories\TransactionRepositoryInterface;
use App\Contracts\Services\PaymentServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaystarPaymentService implements PaymentServiceInterface
{
    protected $callBackUrl;
    protected $paymentLinkPrefix = 'https://core.paystar.ir/api/pardakht/payment';
    public function __construct()
    {
        $this->callBackUrl = env('APP_URL') . '/api/callback';
    }
    protected function http()
    {
        return Http::withHeaders(["Content-Type" => "application/json", "Authorization" => "Bearer " . env("PAYSTAR_GATEWAY_ID")]);
    }
    protected function generateSign($str)
    {
        return hash_hmac('sha512', $str, env('PAYSTAR_GATEWAY_SECRET'));
    }
    public function createPayment($data): string
    {
        $packageRepository = app()->make(PackageRepositoryInterface::class);
        $transactionRepository = app()->make(TransactionRepositoryInterface::class);

        $data['price'] = $packageRepository->findOrFail($data['package_id'])->price;
        $data['user_id'] = $data['user_id'] ?? Auth::user()->id;

        $order = $transactionRepository->create($data);

        $response = $this->http()->post("https://core.paystar.ir/api/pardakht/create", [
            'amount' => $data['price'],
            'order_id' => $order->id,
            'callback' => $this->callBackUrl,
            'card_number' => (string) $data['card'],
            'sign' => $this->generateSign($data['price'] . '#' . $order->id . '#' . $this->callBackUrl)
        ]);

        $response = json_decode($response->body());
        if ($response->status == 1) {
            $transactionRepository->update($order->id, ['ref' => $response->data->ref_num]);
            return $this->paymentLinkPrefix . '?token=' . $response->data->token;
        } else {
            throw new \Exception('cant create payment link');
        }
    }

    public function verifyPayment($data): void
    {
        $transactionRepository = app()->make(TransactionRepositoryInterface::class);
        $transaction = $transactionRepository->find($data['order_id']);


        if ($data['status'] == 1) {
            if (substr($transaction->card, 0, 5) !== substr($data['card_number'], 0, 5) || substr($transaction->card, -4) !== substr($data['card_number'], -4)) {
                $transactionRepository->update($data['order_id'], ['status' => 'failed', 'message' => 'تراکنش با کارت دیگری پرداخت شد']);
                return;
            }
            $response = $this->http()->post("https://core.paystar.ir/api/pardakht/verify", [
                'ref_num' => $data['ref_num'],
                'amount' => $transaction->price,
                'sign' => $this->generateSign($transaction->price . '#' . $data['ref_num'] . '#' . $data['card_number'] . '#' . $data['tracking_code'])
            ]);
            $res = json_decode($response->body());
            $transactionRepository->update($data['order_id'], ['message' => $res->message]);
            if ($res->status == 1) {
                $transactionRepository->update($data['order_id'], ['status' => 'success', 'paid_at' => now()]);
            } else {
                $transactionRepository->update($data['order_id'], ['status' => 'failed']);
            }
        } else {
            $transactionRepository->update($data['order_id'], ['status' => 'failed', 'message' => 'تراکنش کنسل شد']);
        }

    }

}


?>