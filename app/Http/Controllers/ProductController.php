<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Halaman utama / listing semua produk
    public function index(Request $request)
    {
        $categories = Category::active()->withCount('activeProducts')->get();

        $query = Product::active()->with(['category', 'images']);

        // Filter by kategori
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter ready stock / custom
        if ($request->filled('type')) {
            if ($request->type === 'custom') {
                $query->where('is_custom', true);
            } elseif ($request->type === 'ready') {
                $query->where('is_custom', false);
            }
        }

        // Search by nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('products.index', compact('products', 'categories'));
    }

    // Halaman detail produk
    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $product->load(['category', 'images']);

        // Produk lain dari kategori yang sama
        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}