<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Welcome', [
            'categories' => Category::where('is_active', 1)->whereNull('parent_id')->get(),
            'products' => Product::latest()->take(10)->get(),
        ]);
    }
}
