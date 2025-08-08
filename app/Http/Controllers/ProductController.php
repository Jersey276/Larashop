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
            'categories' => Category::with('children')->whereNull('parent_id')->get(),
        ]);
    }

    public function adminEdit(Product $product)
    {
        $product->load('categories');
        $productArray = $product->toArray();
        $productArray['categories'] = $product->categories->pluck('id')->toArray();
        $default = $product->categories()->wherePivot('default', true)->first();
        $productArray['category_id'] = $default ? $default->id : null;

        return Inertia::render('admin/products/form', [
            'product' => $productArray,
            'categories' => Category::with('children')->whereNull('parent_id')->get(),
        ]);
    }

    public function apiIndex()
    {
        $products = Product::with(['categories'])->paginate(20);

        $products->getCollection()->transform(function ($product) {
            $defaultCategory = $product->categories->firstWhere('pivot.default', true);
            if (!$defaultCategory) {
                $defaultCategory = $product->categories->first();
            }
            $product->category = $defaultCategory ? $defaultCategory->name : null;
            unset($product->categories);
            return $product;
        });

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
            'reference' => 'required|string|max:20|unique:products,reference',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|max:255|unique:products,sku',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $product = Product::create($request->except('categories'));
        $product->categories()->attach($request->input('categories'));
        if ($request->filled('category_id')) {
            $product->categories()->updateExistingPivot($request->input('category_id'), ['default' => true]);
        }

        return response()->json(['success' => true, 'product' => $product]);
    }

    public function apiUpdate(Request $request, Product $product)
    {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'reference' => 'required|string|max:20|unique:products,reference,' . $product->id,
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
                'categories' => 'required|array',
                'categories.*' => 'exists:categories,id',
            ]);

        $product->update($request->except('categories'));
        $product->categories()->sync($request->input('categories'));
        if ($request->filled('category_id')) {
            $product->categories()->updateExistingPivot($request->input('category_id'), ['default' => true]);
        }


        return response()->json(['success' => true, 'product' => $product]);
    }

}
