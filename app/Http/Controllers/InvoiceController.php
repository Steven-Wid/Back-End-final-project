<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $query = Invoice::with('items.product.category', 'user')->latest();

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $invoices = $query->get();
        return view('user.invoices.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('user.products.index')
                ->with('error', 'Keranjang belanja kosong. Pilih barang terlebih dahulu.');
        }

        $products = Product::with('category')->whereIn('id', array_keys($cart))->get();
        return view('user.invoices.create', compact('cart', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address'     => 'required|string|max:100',
            'postal_code' => ['required', 'string', 'regex:/^\d{5}$/'],
            'quantities'  => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ], [
            'address.max'        => 'Alamat maksimal 100 huruf',
            'postal_code.regex'  => 'Kode Pos harus tepat 5 digit angka',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('user.products.index')
                ->with('error', 'Keranjang kosong.');
        }

        // Validate stock
        foreach ($request->quantities as $productId => $qty) {
            $product = Product::find($productId);
            if (!$product) continue;
            if ($product->stock < $qty) {
                return back()->with('error', "Stok {$product->name} tidak cukup. Stok tersedia: {$product->stock}");
            }
        }

        // Generate invoice number
        $invoiceNumber = 'INV-' . strtoupper(Str::random(4)) . '-' . now()->format('YmdHis');

        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'user_id'        => auth()->id(),
            'address'        => $request->address,
            'postal_code'    => $request->postal_code,
            'total_price'    => 0,
        ]);

        $total = 0;
        foreach ($request->quantities as $productId => $qty) {
            $product = Product::find($productId);
            if (!$product) continue;

            $subtotal = $product->price * $qty;
            $total   += $subtotal;

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $product->id,
                'quantity'   => $qty,
                'subtotal'   => $subtotal,
            ]);

            // Reduce stock
            $product->decrement('stock', $qty);
        }

        $invoice->update(['total_price' => $total]);

        session()->forget('cart');

        return redirect()->route('user.invoices.show', $invoice->id)
            ->with('success', 'Faktur berhasil disimpan!');
    }

    public function show($id)
    {
        $query = Invoice::with('items.product.category', 'user');

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $invoice = $query->findOrFail($id);
        return view('user.invoices.show', compact('invoice'));
    }

    public function print($id)
    {
        $query = Invoice::with('items.product.category', 'user');

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $invoice = $query->findOrFail($id);
        return view('user.invoices.print', compact('invoice'));
    }
}
