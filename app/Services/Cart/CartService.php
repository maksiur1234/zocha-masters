<?php

namespace App\Services\Cart;

use App\Http\Requests\Cart\StoreCartRequest;

class CartService
{
    public function getCart()
    {
        return session()->get('cart', []);
    }
    public function add(StoreCartRequest $storeCartRequest)
    {
        $cart = $this->getCart();
        $productId = $storeCartRequest->input('product_id');

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'name' => $storeCartRequest->input('name'),
                'price' => $storeCartRequest->input('price'),
                'quantity' => 1,
                'image' => $storeCartRequest->input('image'),
            ];
        }

        session()->put('cart', $cart);

        return $cart;
    }

    public function removeProduct($productId)
    {
        $cart = $this->getCart();

        if(isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);

            return response()->json(['message' => 'Product removed from cart!', 'cart' => $cart], 200);
        }

        return response()->json(['message' => 'Product not found in cart!'], 404);
    }
}
