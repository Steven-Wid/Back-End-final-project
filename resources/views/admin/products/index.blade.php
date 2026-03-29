<x-app-layout>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-base font-semibold text-gray-700">Daftar Produk</h1>
        <a href="{{ route('products.create') }}"
           class="bg-gray-800 text-white text-xs px-3 py-1.5 rounded hover:bg-gray-700 transition">
            + Tambah
        </a>
    </div>

    @if($products->isEmpty())
        <p class="text-sm text-gray-400 py-8 text-center">Belum ada produk.</p>
    @else
    <div class="bg-white border border-gray-200 rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 font-medium">Foto</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 font-medium">Nama</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 font-medium">Kategori</th>
                    <th class="px-4 py-2 text-right text-xs text-gray-500 font-medium">Harga</th>
                    <th class="px-4 py-2 text-right text-xs text-gray-500 font-medium">Stok</th>
                    <th class="px-4 py-2 text-center text-xs text-gray-500 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($products as $p)
                <tr>
                    <td class="px-4 py-2">
                        <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}"
                             class="w-10 h-10 object-cover rounded">
                    </td>
                    <td class="px-4 py-2 text-gray-700">{{ $p->name }}</td>
                    <td class="px-4 py-2 text-gray-500 text-xs">{{ $p->category->name }}</td>
                    <td class="px-4 py-2 text-right text-gray-700">Rp. {{ number_format($p->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 text-right @if($p->stock <= 0) text-red-500 @else text-gray-600 @endif">
                        {{ $p->stock <= 0 ? 'Habis' : $p->stock }}
                    </td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('products.edit', $p->id) }}"
                           class="text-xs text-blue-500 hover:underline mr-2">Edit</a>
                        <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus produk ini?')"
                                    class="text-xs text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-app-layout>
