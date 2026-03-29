<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'name'        => 'required|min:0|max:80',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'required|image|max:2048',
        ]);

        $imagePath = $req->file('image')->store('products', 'public');

        Product::create([
            'name'        => $req->name,
            'price'       => $req->price,
            'stock'       => $req->stock,
            'category_id' => $req->category_id,
            'image'       => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $req, $id)
    {
        $product = Product::findOrFail($id);

        $req->validate([
            'name'        => 'required|min:0|max:80',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'        => $req->name,
            'price'       => $req->price,
            'stock'       => $req->stock,
            'category_id' => $req->category_id,
        ];

        if ($req->file('image')) {
            $data['image'] = $req->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
