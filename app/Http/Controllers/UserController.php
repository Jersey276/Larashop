<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function adminIndex()
    {
        $customers = User::customer()->paginate(20);
        return Inertia::render('admin/customers/index', [
            'customers' => $customers,
        ]);
    }

    public function adminView(User $user)
    {
        return Inertia::render('admin/customers/view', [
            'user'      => $user,
            'orders'    => $user->orders,
            'addresses' => $user->addresses,
            'carts'     => $user->carts
        ]);
    }

    public function apiIndex(Request $request)
    {
        $query = User::query()->customer();

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
        $products = $query->select('id', 'name', 'email', 'created_at')
            ->withCount(['orders'])
            ->paginate($perPage);

        return response()->json($products);
    }
}
