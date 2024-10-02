<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\BlogPost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::all();

        return response()->json($posts);
    }

    public function details($id)
    {
        $post = BlogPost::findOrFail($id); 

        return Inertia::render('Blog/PostDetail', [
            'post' => $post,
        ]);
    }
}
