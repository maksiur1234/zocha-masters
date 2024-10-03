<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        $cart = $this->cartService->getCart();

        return Inertia('Cart/Index', ['cart' => $cart]);
    }
    public function add(StoreCartRequest $storeCartRequest)
    {
        $cart = $this->cartService->add($storeCartRequest);

        return response()->json(['message' => 'Product added to cart!', 'cart' => $cart], 200);
    }

    public function delete($productId)
    {
        $cart = $this->cartService->removeProduct($productId);

        return response()->json(['message' => 'Product removed from cart!', 'cart' => $cart], 200);
    }

    public function data()
    {
        return $this->cartService->getCart();
    }
}
