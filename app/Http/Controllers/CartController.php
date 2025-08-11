<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = currentUser()->cartItems;
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $product = Product::find($validate['product_id']);
        $cart = currentUser()->lastCart();
        if (!$cart) {
            $cart = currentUser()->carts()->create();
        }
        if (($item = $cart->items()->where('product_id', $request->product_id))->exists()) {
            $item->increment('quantity', $request->quantity);
            $item->increment('price', $product->price * $request->quantity);
        } else {
            $item = $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $product->price * $request->quantity,
            ]);
        }
        return response()->json(['success' => true]);
    }
    public function remove(Request $request, $itemId)
    {
        currentUser()->cartItems()->detach($itemId);
        return response()->json(['success' => true]);
    }
    public function clear()
    {
        currentUser()->cartItems()->detach();
        return response()->json(['success' => true]);
    }

    public function checkout()
    {
        /** @TODO: Implement checkout logic */
        return Inertia::render('checkout');
    }
}
