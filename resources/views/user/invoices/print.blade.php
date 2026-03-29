<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur {{ $invoice->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .page { max-width: 560px; margin: 24px auto; padding: 24px; border: 1px solid #ddd; }
        .header { border-bottom: 1px solid #ddd; padding-bottom: 12px; margin-bottom: 16px; }
        .header h1 { font-size: 15px; font-weight: bold; }
        .header p { font-size: 11px; color: #888; margin-top: 2px; }
        .invoice-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #eee; }
        .meta-block .label { font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; color: #aaa; margin-bottom: 3px; }
        .meta-block .value { font-weight: 600; }
        .meta-block .sub { font-size: 11px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 11px; }
        thead th { background: #f5f5f5; padding: 6px 8px; text-align: left; font-size: 10px; color: #888; text-transform: uppercase; }
        tbody td { padding: 7px 8px; border-bottom: 1px solid #f0f0f0; }
        .tr { text-align: right; }
        .tc { text-align: center; }
        tfoot td { padding: 8px; font-weight: bold; border-top: 1px solid #ddd; background: #fafafa; }
        .footer { margin-top: 16px; padding-top: 12px; border-top: 1px dashed #ddd; font-size: 10px; color: #aaa; text-align: center; }
        .actions { text-align: center; margin: 16px; }
        .actions button { font-size: 12px; padding: 7px 18px; border: none; border-radius: 4px; cursor: pointer; margin: 0 4px; }
        .btn-print { background: #1f2937; color: #fff; }
        .btn-close { background: #e5e7eb; color: #374151; }
        @media print { .actions { display: none; } body { margin: 0; } .page { border: none; margin: 0; padding: 16px; } }
    </style>
</head>
<body>

    <div class="actions">
        <button class="btn-print" onclick="window.print()">Cetak / Simpan PDF</button>
        <button class="btn-close" onclick="window.close()">Tutup</button>
    </div>

    <div class="page">
        <div class="header">
            <h1>ChipiChapa Store</h1>
            <p>Faktur Pembelian</p>
        </div>

        <div class="invoice-meta">
            <div class="meta-block">
                <p class="label">No. Invoice</p>
                <p class="value" style="font-family:monospace">{{ $invoice->invoice_number }}</p>
            </div>
            <div class="meta-block">
                <p class="label">Tanggal</p>
                <p class="value">{{ $invoice->created_at->format('d F Y') }}</p>
                <p class="sub">{{ $invoice->created_at->format('H:i') }} WIB</p>
            </div>
            <div class="meta-block">
                <p class="label">Pembeli</p>
                <p class="value">{{ $invoice->user->name }}</p>
                <p class="sub">{{ $invoice->user->email }}</p>
            </div>
            <div class="meta-block">
                <p class="label">Alamat Pengiriman</p>
                <p class="value">{{ $invoice->address }}</p>
                <p class="sub">Kode Pos: {{ $invoice->postal_code }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th class="tc">Qty</th>
                    <th class="tr">Harga Satuan</th>
                    <th class="tr">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->product->category->name }}</td>
                    <td class="tc">x{{ $item->quantity }}</td>
                    <td class="tr">Rp. {{ number_format($item->product->price, 0, ',', '.') }}</td>
                    <td class="tr">Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="tr">TOTAL</td>
                    <td class="tr">Rp. {{ number_format($invoice->total_price, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>Terima kasih telah berbelanja di ChipiChapa Store.</p>
            <p>Simpan faktur ini sebagai bukti pembelian.</p>
        </div>
    </div>

</body>
</html>
