<?php

namespace App\Repository\Blog;

use App\Models\Blog\BlogPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BlogPostRepo extends Model
{
    public function savePost(array $validatedPost)
    {
        BlogPost::create([
            'title' => $validatedPost['title'],
            'excerpt' => $validatedPost['excerpt'],
            'content' => $validatedPost['content'],
            'user_id' => Auth::id(),
        ]);
    }
}
