<x-app-layout>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-base font-semibold text-gray-700">Katalog Produk</h1>
        @php $cartCount = array_sum(session('cart', [])); @endphp
        @if($cartCount > 0)
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400">{{ $cartCount }} item</span>
                <a href="{{ route('user.invoices.create') }}"
                   class="bg-gray-800 text-white text-xs px-3 py-1.5 rounded hover:bg-gray-700 transition">
                    Buat Faktur
                </a>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button class="text-xs text-gray-400 hover:text-gray-600 border border-gray-200 px-2 py-1.5 rounded">Kosongkan</button>
                </form>
            </div>
        @endif
    </div>

    @if($products->isEmpty())
        <p class="text-sm text-gray-400 py-8 text-center">Belum ada produk.</p>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($products as $p)
        <div class="bg-white border border-gray-200 rounded overflow-hidden flex flex-col">
            <div class="relative">
                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}"
                     class="w-full h-36 object-cover">
                @if($p->stock <= 0)
                    <div class="absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center">
                        <span class="text-xs font-semibold text-red-500 border border-red-300 bg-white px-2 py-1 rounded">Stok Habis</span>
                    </div>
                @endif
            </div>
            <div class="p-3 flex flex-col flex-1">
                <p class="text-xs text-gray-400 mb-0.5">{{ $p->category->name }}</p>
                <p class="text-sm font-medium text-gray-700 mb-1 leading-tight">{{ $p->name }}</p>
                <p class="text-sm font-semibold text-gray-800 mb-2">Rp. {{ number_format($p->price, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mb-3">Stok: {{ $p->stock <= 0 ? 'Habis' : $p->stock }}</p>
                <div class="mt-auto">
                    @if($p->stock <= 0)
                        <button disabled
                                class="w-full text-xs text-gray-400 border border-gray-200 rounded px-2 py-1.5 cursor-not-allowed bg-gray-50"
                                title="Barang sudah habis, silakan tunggu hingga barang di-restock ulang">
                            Tidak Tersedia
                        </button>
                    @else
                        <form action="{{ route('cart.add', $p->id) }}" method="POST">
                            @csrf
                            <button class="w-full text-xs text-white bg-gray-800 hover:bg-gray-700 rounded px-2 py-1.5 transition">
                                + Keranjang
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</x-app-layout>
