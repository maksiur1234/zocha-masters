<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10); 
        return response()->json([
            'data' => ProductResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'links' => [
                    'first' => $products->url(1),
                    'last' => $products->url($products->lastPage()),
                    'prev' => $products->previousPageUrl(),
                    'next' => $products->nextPageUrl(),
                ],
            ],
        ]);
    }

    public function getPromoted()
    {
        $promotedProducts = Product::where('is_promoted', 1)->get();

        return response()->json($promotedProducts);
    }

    public function details($id)
    {
        $product = Product::findOrFail($id); 

        return Inertia::render('Shop/ProductDetail', [
            'product' => $product,
        ]);
    }
}
