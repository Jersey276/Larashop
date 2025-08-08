<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function view(Product $product)
    {
        return Inertia::render('products/view', [
            'product' => $product,
            //'reviews' => $product->reviews,
            //'related' => $product->relatedProducts,
        ]);
    }

    public function adminIndex()
    {
        $products = Product::paginate(20);
        return Inertia::render('admin/products/index', [
            'products' => $products,
        ]);
    }

    public function adminAdd()
    {
        return Inertia::render('admin/products/form', [
            'categories' => Category::pluck('name', 'id')->toArray(),
        ]);
    }

    public function adminEdit(Product $product)
    {
        return Inertia::render('admin/products/form', [
            'product' => $product,
            'categories' => Category::pluck('name', 'id')->toArray(),
        ]);
    }

    public function apiIndex()
    {
        $products = Product::paginate(20);
        return response()->json($products);
    }

    public function apiView(Product $product)
    {
        return response()->json($product);
    }

    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($data);
        return response()->json($product, 201);
    }

    public function apiUpdate(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($data);
        return response()->json($product);
    }

}
