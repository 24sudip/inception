<?php

namespace App\Http\Controllers\Api\Posts;

use App\Customs\Services\Post\PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Models\Post;
use App\Models\User;

// use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $post) {

    }

    public function exceptionalError($msg, $th) {
        return response()->json(data:[
            'status'=>'failed',
            'message'=>'Post'.$msg.'failed, please try again later:'. $th->getMessage()
        ],status:500);
    }

    public function getUserPosts(User $user) {
        try {
            $posts = $this->post->userPosts($user);
            if ($posts->count() < 1) {
                return response()->json([
                    'status'=>'success',
                    'message'=>'No post was found for this user'
                ]);
            }
            return response()->json([
                'status'=>'success',
                'message'=>'Posts fetched successfully',
                'data'=>$posts
            ]);
        } catch (\Throwable $th) {
            return $this->exceptionalError('fetching', $th);
        }
    }

    public function fetchPosts() {
        try {
            $posts = $this->post->getPosts();
            if ($posts->count() < 1) {
                return response()->json([
                    'status'=>'success',
                    'message'=>'No post was found for this user'
                ]);
            }
            return response()->json([
                'status'=>'success',
                'message'=>'Posts fetched successfully',
                'data'=>$posts
            ]);
        } catch (\Throwable $th) {
            return $this->exceptionalError('fetching', $th);
        }
    }

    public function show(Post $post) {
        return response()->json([
            'status'=>'success',
            'message'=>'Post fetched successfully',
            'data'=>$post
        ]);
    }

    public function store(CreatePostRequest $request) {
        $validatedData = $request->validated();
        try {
            $post = $this->post->create($validatedData);
            return response()->json(data:[
                'status'=>'success',
                'message'=>'Post created successfully',
                'data'=>$post
            ],status:201);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->exceptionalError('creation', $th);
        }
    }

    public function update(CreatePostRequest $request, Post $post) {
        try {
            $validatedData = $request->validated();
            $post = $this->post->updatePost($post, $validatedData);
            return response()->json([
                'status'=>'success',
                'message'=>'Post updated successfully',
                'data'=>$post
            ],status:200);
        } catch (\Throwable $th) {
            return $this->exceptionalError('update', $th);
        }
    }

    public function delete(Post $post) {
        try {
            $deletePost = $this->post->deletePost($post);
            if (!$deletePost) {
                return response()->json([
                    'status'=>'failed',
                    'message'=>'An error occured while trying to delete post, please try again later'
                ],status:500);
            }
            return response()->json([
                'status'=>'success',
                'message'=>'Post deleted successfully'
            ],status:200);
        } catch (\Throwable $th) {
            return $this->exceptionalError('delete', $th);
        }
    }
}
