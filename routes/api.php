<?php

// use App\Http\Controllers\Api\Auth\AuthController;
// use App\Http\Controllers\Api\Profile\PasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__ . '/auth.php';
require __DIR__ . '/posts/post.php';

