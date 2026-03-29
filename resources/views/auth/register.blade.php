<x-guest-layout>
    <h2 class="text-base font-semibold text-gray-700 mb-4">Daftar Akun</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf
        <div>
            <label class="block text-xs text-gray-500 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   placeholder="Min. 3, maks. 40 huruf"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Email (@gmail.com)</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   placeholder="contoh@gmail.com"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
            @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Nomor HP</label>
            <input type="text" name="phone" value="{{ old('phone') }}" required
                   placeholder="08xxxxxxxxxx"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
            @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Password (6–12 huruf)</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
            @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
        </div>
        <button type="submit"
                class="w-full bg-gray-800 text-white text-sm rounded px-3 py-2 hover:bg-gray-700 transition">
            Daftar
        </button>
        <p class="text-xs text-center text-gray-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-gray-600 underline">Masuk</a>
        </p>
    </form>
</x-guest-layout>
