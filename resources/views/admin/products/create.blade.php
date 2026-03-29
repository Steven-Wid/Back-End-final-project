<x-app-layout>
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-xs text-gray-400 hover:text-gray-600">← Kembali</a>
        <h1 class="text-base font-semibold text-gray-700 mt-1">Tambah Produk</h1>
    </div>

    <div class="bg-white border border-gray-200 rounded p-5 max-w-lg">
        @if($errors->any())
            <div class="mb-3 text-xs text-red-600 bg-red-50 border border-red-200 rounded px-3 py-2">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf

            <div>
                <label class="block text-xs text-gray-500 mb-1">Kategori <span class="text-red-400">*</span></label>
                <select name="category_id" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Nama Barang <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="Min. 5, maks. 80 huruf"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Harga <span class="text-red-400">*</span></label>
                <div class="flex items-center border border-gray-300 rounded overflow-hidden focus-within:border-gray-500">
                    <span class="px-3 py-2 text-sm text-gray-500 bg-gray-50 border-r border-gray-300">Rp.</span>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0"
                           class="flex-1 px-3 py-2 text-sm focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Jumlah Stok <span class="text-red-400">*</span></label>
                <input type="number" name="stock" value="{{ old('stock') }}" required min="0"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Foto Barang <span class="text-red-400">*</span></label>
                <input type="file" name="image" required accept="image/*"
                       class="w-full text-sm text-gray-500 border border-gray-300 rounded px-3 py-1.5">
            </div>

            <div class="flex gap-2 pt-1">
                <button type="submit"
                        class="bg-gray-800 text-white text-sm rounded px-4 py-2 hover:bg-gray-700 transition">
                    Simpan
                </button>
                <a href="{{ route('products.index') }}"
                   class="bg-gray-100 text-gray-600 text-sm rounded px-4 py-2 hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
