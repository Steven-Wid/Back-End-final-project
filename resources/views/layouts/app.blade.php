<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ChipiChapa Store') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 flex items-center justify-between h-12">
            <div class="flex items-center gap-6">
                <span class="font-semibold text-gray-700 text-sm">ChipiChapa</span>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('products.index') }}" class="text-sm text-gray-500 hover:text-gray-800">Produk</a>
                        <a href="{{ route('user.invoices.index') }}" class="text-sm text-gray-500 hover:text-gray-800">Faktur</a>
                    @else
                        <a href="{{ route('user.products.index') }}" class="text-sm text-gray-500 hover:text-gray-800">Katalog</a>
                        <a href="{{ route('user.invoices.index') }}" class="text-sm text-gray-500 hover:text-gray-800">Faktur</a>
                        @php $cartCount = array_sum(session('cart', [])); @endphp
                        <a href="{{ route('user.invoices.create') }}" class="text-sm text-gray-500 hover:text-gray-800">
                            Keranjang{{ $cartCount > 0 ? ' ('.$cartCount.')' : '' }}
                        </a>
                    @endif
                @endauth
            </div>
            @auth
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-400">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs text-gray-400 hover:text-gray-700">Keluar</button>
                </form>
            </div>
            @endauth
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded px-3 py-2">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded px-3 py-2">{{ session('error') }}</div>
        @endif
        {{ $slot }}
    </main>

</body>
</html>
