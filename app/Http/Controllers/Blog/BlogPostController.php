<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StorePostRequest;
use App\Http\Resources\BlogPostResource;
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
        $posts = BlogPost::paginate(10);

        return response()->json([
            'data' => BlogPostResource::collection($posts),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ],
        ]);
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
            return response()->json(['message' => 'Saved sucesfully']);
        } catch (\Exception $e) {
            Log::error("Error in addding new post: ". $e->getMessage());
        }
        
    }

    public function editView($id)
    {
        $post = BlogPost::findOrFail($id); 

        return Inertia::render('Blog/PostDetailEdit', [
            'post' => $post,
        ]);
    }

    public function edit(StorePostRequest $storePostRequest, $id)
    {
        $validatedPost = $storePostRequest->validated();

        try {
            $this->blogPostRepo->edit($id, $validatedPost);
            return response()->json(['message' => 'Updated sucesfully']);
        } catch (\Exception $e) {
            Log::error("Error in editing post: ". $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->blogPostRepo->deletePost($id);
            return response()->json(['message' => 'Delted sucesfully']);
        } catch (\Exception $e) {
            Log::error("Error in deleting post: ". $e->getMessage());
        }
    }
}
