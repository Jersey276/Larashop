<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(20);
        return Inertia::render('orders/index', [
            'orders' => $orders,
        ]);
    }
    public function adminIndex()
    {
        $orders = Order::paginate(20);
        return Inertia::render('admin/orders/index', [
            'orders' => $orders,
        ]);
    }
}
