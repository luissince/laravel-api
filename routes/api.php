<?php

use App\Http\Controllers\Session\AuthController;
use App\Http\Controllers\Voucher\VoucherController;
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

// Route::group(['middleware' => ["auth:sanctum"]], function () {
//     Route::apiResource('/users', UserController::class);
// });

// Route::get('/users', [UserController::class, 'index']);

// Route::get('/user', [UserController::class, 'user']);

// Route::delete('/logout', [AuthController::class, 'logout']);

// Route::post('/login', [AuthController::class, 'login']);

// Route::post('/signup', [UserController::class, 'signup']);

Route::post('/login', [AuthController::class, 'login']);

Route::delete('/logout', [AuthController::class, 'logout']);

Route::get('/contribuyente', [AuthController::class, 'contribuyente']);

Route::get('/validtoken', [AuthController::class, 'validtoken']);

Route::get('/lista', [VoucherController::class, 'lista']);
