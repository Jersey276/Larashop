<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category)
    {
        $products = $category->products()->paginate(10);
        return Inertia::render('category/show', [
            'category' => $category,
            'products' => $products,
        ]);
    }

    public function adminIndex()
    {
        $categories = Category::pluck('name', 'id')->toArray();
        return Inertia::render('admin/categories/index', [
            'categories' => $categories,
        ]);
    }

    public function adminAdd(Request $request)
    {
        return Inertia::render('admin/categories/form', [
            'categories' => Category::pluck('name', 'id')->toArray(),
        ]);
    }

    public function adminEdit(Request $request, Category $category)
    {
        return Inertia::render('admin/categories/form', [
            'category' => $category,
            'categories' => Category::pluck('name', 'id')->toArray(),
        ]);
    }
    

    public function apiIndex(Request $request)
    {
        $query = Category::query()->with('parentCategory');

        // Recherche
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Tri
        if ($request->filled('sort')) {
            $sortFields = explode(',', $request->sort);
            foreach ($sortFields as $sortField) {
                $direction = strpos($sortField, '-') === 0 ? 'desc' : 'asc';
                $field = ltrim($sortField, '-');
                $query->orderBy($field, $direction);
            }
        }

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 10;
        $categories = $query->select('id', 'name', 'description', 'parent_id')->paginate($perPage);
        $categories->getCollection()->transform(function ($category) {
            $category->parent_name = $category->parentCategory ? $category->parentCategory->name : null;
            return $category;
        });

        return response()->json($categories);
    }

    public function apiShow(Request $request)
    {
        $query = Product::query();

        // Recherche
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Tri
        if ($request->has('sort')) {
            $sortFields = explode(',', $request->sort);
            foreach ($sortFields as $sortField) {
                $direction = strpos($sortField, '-') === 0 ? 'desc' : 'asc';
                $field = ltrim($sortField, '-');
                $query->orderBy($field, $direction);
            }
        }

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 10;
        $products = $query->paginate($perPage);

        return response()->json($products);
    }
    
    public function apiStore(Request $request)
    {
        $categoryData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => ['nullable','exists:categories','id']
        ]);

        $category = Category::create($categoryData);
        return response()->json(['success' => true, 'category' => $category]);
    }
    
    public function apiUpdate(Request $request, Category $category)
    {
        $categoryData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => ['nullable','exists:categories,id',function ($attribute, $value, $fail) use ($category) {
                if ($value == $category->id) {
                    $fail('Une catégorie ne peut pas être son propre parent.');
                }
                // Vérifie la boucle ascendante
                $parentId = $value;
                while ($parentId) {
                    if ($parentId == $category->id) {
                        $fail('Boucle de parenté détectée.');
                        break;
                    }
                    $parent = \App\Models\Category::find($parentId);
                    $parentId = $parent ? $parent->parent_id : null;
                }
            }],
        ]);

        $category->update($categoryData);
        return response()->json(['success' => true, 'category' => $category]);
    }
}
