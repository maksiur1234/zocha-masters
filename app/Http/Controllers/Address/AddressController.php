<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Models\Address\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(StoreAddressRequest $storeOrderRequest)
    {
        $validatedOrder = $storeOrderRequest->validated();

        Address::create([
            'address_line_1' => $validatedOrder['address_line_1'],
            'address_line_2' => $validatedOrder['address_line_2'] ?? null,  
            'city' => $validatedOrder['city'],
            'country' => $validatedOrder['country'],
            'first_name' => $validatedOrder['first_name'],
            'last_name' => $validatedOrder['last_name'],
            'phone' => $validatedOrder['phone'],
            'postal_code' => $validatedOrder['postal_code'],
            'user_id' => Auth::id(), 
        ]);
        return response()->json(['message' => 'Address details saved successfully!'], 200);
    }
}
