<x-app-layout>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-base font-semibold text-gray-700">
            {{ auth()->user()->isAdmin() ? 'Semua Faktur' : 'Faktur Saya' }}
        </h1>
        @if(!auth()->user()->isAdmin())
        <a href="{{ route('user.products.index') }}"
           class="bg-gray-800 text-white text-xs px-3 py-1.5 rounded hover:bg-gray-700 transition">
            Belanja
        </a>
        @endif
    </div>

    @if($invoices->isEmpty())
        <p class="text-sm text-gray-400 py-8 text-center">Belum ada faktur.</p>
    @else
    <div class="bg-white border border-gray-200 rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 font-medium">No. Invoice</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 font-medium">Tanggal</th>
                    @if(auth()->user()->isAdmin())
                    <th class="px-4 py-2 text-left text-xs text-gray-500 font-medium">User</th>
                    @endif
                    <th class="px-4 py-2 text-left text-xs text-gray-500 font-medium">Alamat</th>
                    <th class="px-4 py-2 text-right text-xs text-gray-500 font-medium">Total</th>
                    <th class="px-4 py-2 text-center text-xs text-gray-500 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($invoices as $inv)
                <tr>
                    <td class="px-4 py-2 text-xs text-gray-600 font-mono">{{ $inv->invoice_number }}</td>
                    <td class="px-4 py-2 text-xs text-gray-500">{{ $inv->created_at->format('d M Y') }}</td>
                    @if(auth()->user()->isAdmin())
                    <td class="px-4 py-2 text-xs text-gray-500">{{ $inv->user->name }}</td>
                    @endif
                    <td class="px-4 py-2 text-xs text-gray-500 max-w-xs truncate">{{ $inv->address }}</td>
                    <td class="px-4 py-2 text-right text-xs text-gray-700 font-medium">Rp. {{ number_format($inv->total_price, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('user.invoices.show', $inv->id) }}"
                           class="text-xs text-blue-500 hover:underline mr-2">Detail</a>
                        <a href="{{ route('user.invoices.print', $inv->id) }}" target="_blank"
                           class="text-xs text-gray-500 hover:underline">Cetak</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-app-layout>
