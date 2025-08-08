<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Logic to display the cart items
        $cartItems = currentUser()->cartItems;
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        // Logic to add an item to the cart
        $item = $request->input('item');
        currentUser()->cartItems()->attach($item);
        return redirect()->route('cart.index')->with('success', 'Item added to cart.');
    }
    public function remove(Request $request, $itemId)
    {
        // Logic to remove an item from the cart
        currentUser()->cartItems()->detach($itemId);
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
    public function clear()
    {
        // Logic to clear the cart
        currentUser()->cartItems()->detach();
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
    public function checkout()
    {
        
    }
}
