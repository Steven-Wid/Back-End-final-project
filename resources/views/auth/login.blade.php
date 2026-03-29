<x-guest-layout>
    <h2 class="text-base font-semibold text-gray-700 mb-4">Masuk</h2>
    <x-auth-session-status class="mb-3 text-sm text-green-600" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-3">
        @csrf
        <div>
            <label class="block text-xs text-gray-500 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
            @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-gray-500">
            @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <button type="submit"
                class="w-full bg-gray-800 text-white text-sm rounded px-3 py-2 hover:bg-gray-700 transition">
            Masuk
        </button>
        <p class="text-xs text-center text-gray-400">
            Belum punya akun? <a href="{{ route('register') }}" class="text-gray-600 underline">Daftar</a>
        </p>
    </form>
</x-guest-layout>
