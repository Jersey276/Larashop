<?php

namespace App\Http\Controllers;

use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShippingMethodController extends Controller
{
    public function apiIndex()
    {
        // Logic to display available shipping methods
        $shippingMethods = currentUser()->shippingMethods;
        return response()->json($shippingMethods);
    }

    public function adminIndex()
    {
        // Logic to display shipping methods for admin
        $shippingMethods = ShippingMethod::all();
        return Inertia::render('admin/shipping_methods/index', [
            'shippingMethods' => $shippingMethods,
        ]);
    }
    public function apiAdd()
    {
        // Logic to add a shipping method
        $shippingMethod = request()->input('shipping_method');
        ShippingMethod::create($shippingMethod);
        return response()->json(['success' => 'Shipping method added successfully.']);
    }

    public function apiRemove($shippingMethodId)
    {
        // Logic to remove a shipping method
        ShippingMethod::destroy($shippingMethodId);
        return response()->json(['success' => 'Shipping method removed successfully.']);
    }
}
