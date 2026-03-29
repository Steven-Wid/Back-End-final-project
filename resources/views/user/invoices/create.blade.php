<x-app-layout>
    <div class="mb-4">
        <a href="{{ route('user.products.index') }}" class="text-xs text-gray-400 hover:text-gray-600">← Kembali</a>
        <h1 class="text-base font-semibold text-gray-700 mt-1">Buat Faktur</h1>
    </div>

    @if($errors->any())
        <div class="mb-3 text-xs text-red-600 bg-red-50 border border-red-200 rounded px-3 py-2">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    {{-- Form hapus item per produk (di luar form utama, pakai id referensi) --}}
    @foreach($products as $p)
        <form id="remove_form_{{ $p->id }}" action="{{ route('cart.remove', $p->id) }}" method="POST" style="display:none">
            @csrf @method('DELETE')
        </form>
    @endforeach

    <form id="invoice_form" action="{{ route('user.invoices.store') }}" method="POST">
        @csrf

        {{-- Items --}}
        <div class="bg-white border border-gray-200 rounded mb-4">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Daftar Barang</p>
            </div>
            @php $grandTotal = 0; @endphp
            @foreach($products as $p)
                @php $qty = $cart[$p->id] ?? 1; $subtotal = $p->price * $qty; $grandTotal += $subtotal; @endphp
                <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-100 last:border-0">
                    <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}"
                         class="w-12 h-12 object-cover rounded border border-gray-100 flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-700 truncate">{{ $p->name }}</p>
                        <p class="text-xs text-gray-400">{{ $p->category->name }} &bull; Rp. {{ number_format($p->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="text-xs text-gray-400">Qty</span>
                        <input type="number" name="quantities[{{ $p->id }}]"
                               value="{{ $qty }}" min="1" max="{{ $p->stock }}" id="qty_{{ $p->id }}"
                               oninput="updateSubtotal({{ $p->id }}, {{ $p->price }})"
                               class="w-16 border border-gray-300 rounded px-2 py-1 text-sm text-center focus:outline-none focus:border-gray-500">
                    </div>
                    <div class="text-right flex-shrink-0 w-28">
                        <p class="text-xs text-gray-400">Subtotal</p>
                        <p class="text-sm font-medium text-gray-700" id="sub_{{ $p->id }}">
                            Rp. {{ number_format($subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        {{-- Gunakan form="remove_form_X" agar button submit ke form hapus, bukan form utama --}}
                        <button type="submit" form="remove_form_{{ $p->id }}"
                                class="text-gray-300 hover:text-red-400 text-sm leading-none">&times;</button>
                    </div>
                </div>
            @endforeach
            <div class="px-4 py-3 flex justify-end items-center gap-3 bg-gray-50">
                <span class="text-xs text-gray-500">Total</span>
                <span class="text-base font-semibold text-gray-800" id="grandTotal">
                    Rp. {{ number_format($grandTotal, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Delivery --}}
        <div class="bg-white border border-gray-200 rounded mb-4">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pengiriman</p>
            </div>
            <div class="px-4 py-4 space-y-3">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Alamat Pengiriman <span class="text-red-400">*</span></label>
                    <textarea name="address" rows="2" required
                              placeholder="Min. 10, maks. 100 huruf"
                              class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">{{ old('address') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Kode Pos <span class="text-red-400">*</span></label>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                           maxlength="5" placeholder="5 digit angka"
                           class="w-32 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
                </div>
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="bg-gray-800 text-white text-sm rounded px-5 py-2 hover:bg-gray-700 transition">
                Simpan Faktur
            </button>
            <a href="{{ route('user.products.index') }}"
               class="bg-gray-100 text-gray-600 text-sm rounded px-5 py-2 hover:bg-gray-200 transition">
                Lanjut Belanja
            </a>
        </div>
    </form>

    <script>
        const prices = @json($products->pluck('price', 'id'));
        function fmt(n) { return 'Rp. ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
        function updateSubtotal(id, price) {
            const qty = parseInt(document.getElementById('qty_' + id).value) || 0;
            document.getElementById('sub_' + id).textContent = fmt(price * qty);
            let total = 0;
            for (const [pid, pr] of Object.entries(prices)) {
                const inp = document.getElementById('qty_' + pid);
                if (inp) total += pr * (parseInt(inp.value) || 0);
            }
            document.getElementById('grandTotal').textContent = fmt(total);
        }
    </script>
</x-app-layout>
