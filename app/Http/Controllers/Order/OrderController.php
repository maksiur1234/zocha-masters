<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Address\Address;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function addressForm()
    {
        return Inertia::render('Order/PlaceOrderAddress');
    }

    public function deliveryForm()
    {
        return Inertia::render('Order/PlaceOrderDelivery');
    }
}
