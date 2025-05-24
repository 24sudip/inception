<?php

namespace App\Customs\Services\Post;

use App\Models\Post;
use App\Models\User;

class PostService
{
    public function create(array $data) {
        $post = auth()->user()->posts()->create($data);
        return $post;
    }

    public function postAuthorizationCheck(Post $post) {
        if ($post->user_id !== auth()->user()->id) {
            throw new \Illuminate\Auth\Access\AuthorizationException(message: 'you do not have permission to update the post');
        }
    }

    public function userPosts(User $user) {
        return $user->posts()->latest()->paginate(12);
    }

    public function getPosts() {
        return Post::with('user:id,name')->latest()->paginate(12);
    }

    public function updatePost(Post $post, array $data) {
        // check if the user is authorized to update the post
        $this->postAuthorizationCheck($post);
        $post->update($data);
        return $post;
    }

    public function deletePost(Post $post) {
        // check if the user is authorized to update the post
        $this->postAuthorizationCheck($post);
        return $post->delete();
    }
}

?>
