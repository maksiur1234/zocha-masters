<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
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
