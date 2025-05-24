<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Profile\PasswordController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/verify-user-email', [AuthController::class, 'verifyUserEmail']);
    Route::post('/resend-email-verification-link', [AuthController::class, 'resendEmailVerificationLink']);
    Route::post('/logout', [AuthController::class, 'logout']);
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/change-password', [PasswordController::class, 'changeUserPassword']);
});

?>
