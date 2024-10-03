<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StorePostRequest;
use App\Models\Blog\BlogPost;
use App\Repository\Blog\BlogPostRepo;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class BlogPostController extends Controller
{
    protected $blogPostRepo;

    public function __construct(BlogPostRepo $blogPostRepo)
    {
        $this->blogPostRepo = $blogPostRepo;
    }
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

    public function newPost()
    {
        return Inertia::render('Blog/AddPost');
    }
    
    public function store(StorePostRequest $storePostRequest)
    {
        $validatedPost = $storePostRequest->validated();

        try {
            $this->blogPostRepo->savePost($validatedPost);
        } catch (\Exception $e) {
            Log::error("Error in addding new post: ". $e->getMessage());
        }
        
    }
}
