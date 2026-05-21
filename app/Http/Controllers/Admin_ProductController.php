<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']); // pastikan hanya admin
    }

    // Daftar semua produk
    public function index()
    {
        $products = Product::with(['category', 'images'])
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    // Form tambah produk
    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required_if:is_custom,false|integer|min:0',
            'is_custom'   => 'boolean',
            'is_active'   => 'boolean',
            'images'      => 'required|array|min:1',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->is_custom ? 0 : $request->stock,
            'is_custom'   => $request->boolean('is_custom'),
            'is_active'   => $request->boolean('is_active', true),
        ]);

        // Upload foto-foto produk
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => $index === 0, // foto pertama = primary
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // Form edit produk
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'is_custom'   => 'boolean',
            'is_active'   => 'boolean',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->boolean('is_custom') ? 0 : $request->stock,
            'is_custom'   => $request->boolean('is_custom'),
            'is_active'   => $request->boolean('is_active'),
        ]);

        // Upload foto baru jika ada
        if ($request->hasFile('images')) {
            $lastOrder = $product->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $product->images()->count() === 0 && $index === 0,
                    'sort_order' => $lastOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus!');
    }

    // Hapus 1 foto produk
    public function destroyImage(ProductImage $image)
    {
        $image->delete();
        return back()->with('success', 'Foto berhasil dihapus!');
    }

    // Set foto sebagai primary
    public function setPrimaryImage(ProductImage $image)
    {
        // Reset semua foto produk ini jadi bukan primary
        ProductImage::where('product_id', $image->product_id)
            ->update(['is_primary' => false]);

        $image->update(['is_primary' => true]);

        return back()->with('success', 'Foto utama berhasil diubah!');
    }
}