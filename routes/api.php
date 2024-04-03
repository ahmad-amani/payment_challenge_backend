<?php

use App\Http\Controllers\Api\Transaction\PaymentController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\Package\PackageController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->name('user.')->group(function () {
    Route::put('user', [UserController::class, 'update'])->name('update');
});
Route::middleware('auth:sanctum')->name('transaction.')->group(function () {
    Route::post('purchase', [PaymentController::class, 'purchase'])->name('purchase');

});
Route::post('register', [AuthController::class, 'register'])->name('user.register');
Route::post('login', [AuthController::class, 'login'])->name('user.login');
Route::get('packages', [PackageController::class, 'index'])->middleware('auth:sanctum')->name('package.list');
Route::post('callback', [PaymentController::class, 'verify'])->name('transaction.callback');