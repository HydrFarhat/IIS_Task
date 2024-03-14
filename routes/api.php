<?php

use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware([
    'auth:sanctum'
])->group(function () {
    Route::middleware("admin")->group(function () {
        Route::post('users/{user}/approve', [AuthController::class, 'approve']);

        Route::get('certificates', [CertificateController::class, 'all']);
        Route::post('certificates', [CertificateController::class, 'create']);
        Route::delete('certificates/{certificate}', [CertificateController::class, 'delete']);
        Route::get('certificates/export', [CertificateController::class, 'export']);
    });

    Route::prefix("profile")->group(function () {
        Route::put('update', [ProfileController::class, 'update']);
        Route::post('certificates/{certificate}', [ProfileController::class, 'add']);
        Route::delete('certificates/{certificate}', [ProfileController::class, 'remove']);
    });
});

