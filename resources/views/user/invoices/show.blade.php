<x-app-layout>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <a href="{{ route('user.invoices.index') }}" class="text-xs text-gray-400 hover:text-gray-600">← Kembali</a>
            <h1 class="text-base font-semibold text-gray-700 mt-1">Detail Faktur</h1>
        </div>
        <a href="{{ route('user.invoices.print', $invoice->id) }}" target="_blank"
           class="bg-gray-800 text-white text-xs px-3 py-1.5 rounded hover:bg-gray-700 transition">
            Cetak
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded max-w-2xl">
        <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-400">No. Invoice</p>
                <p class="text-sm font-mono font-medium text-gray-700">{{ $invoice->invoice_number }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400">Tanggal</p>
                <p class="text-sm text-gray-600">{{ $invoice->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="px-5 py-4 border-b border-gray-100 grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-400 mb-1">Pembeli</p>
                <p class="text-sm text-gray-700">{{ $invoice->user->name }}</p>
                <p class="text-xs text-gray-400">{{ $invoice->user->email }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Alamat Pengiriman</p>
                <p class="text-sm text-gray-700">{{ $invoice->address }}</p>
                <p class="text-xs text-gray-400">Kode Pos: {{ $invoice->postal_code }}</p>
            </div>
        </div>

        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-5 py-2 text-left text-xs text-gray-400 font-medium">Barang</th>
                    <th class="px-5 py-2 text-left text-xs text-gray-400 font-medium">Kategori</th>
                    <th class="px-5 py-2 text-center text-xs text-gray-400 font-medium">Qty</th>
                    <th class="px-5 py-2 text-right text-xs text-gray-400 font-medium">Harga</th>
                    <th class="px-5 py-2 text-right text-xs text-gray-400 font-medium">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($invoice->items as $item)
                <tr>
                    <td class="px-5 py-2 text-sm text-gray-700">{{ $item->product->name }}</td>
                    <td class="px-5 py-2 text-xs text-gray-400">{{ $item->product->category->name }}</td>
                    <td class="px-5 py-2 text-center text-sm text-gray-600">x{{ $item->quantity }}</td>
                    <td class="px-5 py-2 text-right text-xs text-gray-500">Rp. {{ number_format($item->product->price, 0, ',', '.') }}</td>
                    <td class="px-5 py-2 text-right text-sm text-gray-700">Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t border-gray-200 bg-gray-50">
                    <td colspan="4" class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Total</td>
                    <td class="px-5 py-3 text-right text-sm font-bold text-gray-800">
                        Rp. {{ number_format($invoice->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</x-app-layout>
