<?php

namespace App\Repository\Blog;

use App\Models\Blog\BlogPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BlogPostRepo extends Model
{
    public function savePost(array $validatedPost): void
    {
        BlogPost::create([
            'title' => $validatedPost['title'],
            'excerpt' => $validatedPost['excerpt'],
            'content' => $validatedPost['content'],
            'user_id' => Auth::id(),
        ]);
    }

    public function edit($id, array $validatedPost): void
    {
        $post = BlogPost::findOrFail($id);

        $post->update([
            'title' => $validatedPost['title'],
            'excerpt' => $validatedPost['excerpt'],
            'content' => $validatedPost['content'],
        ]);
    }

    public function deletePost($id)
    {
        $post = BlogPost::findOrFail($id);

        $post->delete();
    }
}
