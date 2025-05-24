<?php

use App\Http\Controllers\Api\Posts\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::post('/post/create', [PostController::class, 'store']);
    Route::post('/post/{post}', [PostController::class, 'update'])->missing(missing: fn() => response()->json([
        'status'=>'failed',
        'message'=>'Post not found'
    ],status:404));
    Route::delete('/post/{post}', [PostController::class, 'delete'])->missing(missing: fn() => response()->json([
        'status'=>'failed',
        'message'=>'Post not found'
    ],status:404));
});
Route::get('/post/user/{user}', [PostController::class, 'getUserPosts'])->missing(missing: fn() => response()->json([
    'status'=>'failed',
    'message'=>'user not found'
],status:404));
Route::get('/posts', [PostController::class, 'fetchPosts']);
Route::get('/posts/{post}', [PostController::class, 'show'])->missing(missing: fn() => response()->json([
    'status'=>'failed',
    'message'=>'post not found'
],status:404));

?>
