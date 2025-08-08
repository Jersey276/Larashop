<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = currentUser()->cartItems;
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $item = $request->input('item');
        currentUser()->cartItems()->attach($item);
        return redirect()->route('cart.index')->with('success', 'Item added to cart.');
    }
    public function remove(Request $request, $itemId)
    {
        currentUser()->cartItems()->detach($itemId);
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
    public function clear()
    {
        currentUser()->cartItems()->detach();
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    public function checkout()
    {
        /** @TODO: Implement checkout logic */
        return Inertia::render('checkout');
    }
}
