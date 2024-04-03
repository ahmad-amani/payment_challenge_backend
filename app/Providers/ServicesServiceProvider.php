<?php

namespace App\Providers;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\PaymentServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Repositories\UserRepository;
use App\Services\PaystarPaymentService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(PaymentServiceInterface::class, PaystarPaymentService::class);

    }
}
