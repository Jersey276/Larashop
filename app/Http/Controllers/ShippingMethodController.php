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
        return Inertia::render('admin/shipping/index', [
            'shippingMethods' => $shippingMethods,
        ]);
    }
    public function adminAdd()
    {
        // Logic to show form for adding a new shipping method
        return Inertia::render('admin/shipping/form');
    }

    public function adminEdit(ShippingMethod $shippingMethod)
    {
        // Logic to show form for editing an existing shipping method
        return Inertia::render('admin/shipping/form', [
            'shippingMethod' => $shippingMethod,
        ]);
    }

    public function apiStore(Request $request)
    {
        // Logic to store a new shipping method
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'delivery_time' => 'required|integer',
            'is_active' => 'boolean|nullable',
        ]);

        $shippingMethod = ShippingMethod::create($data);
        return response()->json($shippingMethod, 201);
    }

    public function apiUpdate(Request $request, $shippingMethodId)
    {
        // Logic to update an existing shipping method
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'delivery_time' => 'required|integer',
            'is_active' => 'boolean|nullable',
        ]);

        $shippingMethod = ShippingMethod::findOrFail($shippingMethodId);
        $shippingMethod->update($data);
        return response()->json(['success'=>true, 'shippingMethod'=>$shippingMethod]);
    }

    public function apiRemove($shippingMethodId)
    {
        // Logic to remove a shipping method
        ShippingMethod::destroy($shippingMethodId);
        return response()->json(['success'=>true, 'shippingMethod'=>$shippingMethod]);
    }
}
