<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostTag;

class PostRepository
{
    protected $post;

    function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAllPostsWithTags()
    {
        return $this->post->with('tags')->get();
    }

    public function getPostByPostId($id)
    {
        return $this->post->find($id);
    }

    public function getPostWithTagsByPostId($id)
    {
        return $this->post->with('tags')->find($id);
    }

    public function createPost($request)
    {
        $isSuccess =  $this->post->insert(
            [
                'title' => $request->title,
                'body' => $request->body,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );

        return $isSuccess ? $isSuccess : false;
    }

    public function updatePost($request, $id)
    {
        $post = $this->getPostByPostId($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->updated_at = date('Y-m-d H:i:s');
        return $post->save();
    }

    public function deletePost($id)
    {
        $post = $this->getPostByPostId($id);
        if ($post) {
            $postTag = new PostTag();
            $postTag->where('post_id', $id)->delete();
            return $post->delete();
        }
    }

}