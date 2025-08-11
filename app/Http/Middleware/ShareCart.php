<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ShareCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (currentUser()) {
            Inertia::share('cart', function () {
                $cart = currentUser()->lastCart()->with(['items.product'])->first();

                if ($cart) {
                    return [
                        'items' => $cart->items,
                        'total' => $cart->total,
                    ];
                }

                return [
                    'items' => [],
                    'total' => 0,
                ];
            });
            Inertia::share('cartCount', function () {
                return currentUser()->lastCart()->withCount('items')->first()?->items_count ?? 0;
            });
            Inertia::share('cartEnabled', true);
        }

        return $next($request);
    }
}
