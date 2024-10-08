<?php

namespace App\Http\Controllers\Payment\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StripeController extends Controller
{
    public function index()
    {
        return Inertia::render('Order/PlaceOrderPayment');
    }

    public function checkout(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('payment-index')->with('error', 'Empty card.');
        }

        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $lineItems = [];
        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'pln',
                    'product_data' => [
                        'name' => 'Zakup produktów w sklepie Zocha Masters', 
                    ],
                    'unit_amount' => $item['price'] * 100, // convert to zł
                ],
                'quantity' => $item['quantity'], 
            ];
        }

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('payment-index'),
        ]);

        return response()->json(['url' => $session->url])
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin, Authorization');
    }

    public function success()
    {
        return Inertia::render('Order/PlaceOrderPayment');
    }
}
