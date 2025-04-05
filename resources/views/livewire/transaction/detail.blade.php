<div>
    <x-header title="Detail Transaksi" separator progress-indicator>
    </x-header>
    <x-button class="btn-sm btn-neutral mb-2" icon="bi.arrow-left" label="kembali"
        link="{{ route('transactions.index') }}" />
    <x-card title="Detail transaksi" class="my-6">
        <table class="w-full">
            <tr>
                <td class="w-2/5 py-2 my-3">tanggal transaksi</td>
                <td class="w-3/5 py-2 my-3">: {{ $sale->created_at->locale('id')->isoFormat('dddd DD-MM-Y') }}</td>
            </tr>
            <tr>
                <td class="w-2/5 py-2 my-3">total asli</td>
                <td class="w-3/5 py-2 my-3">: {{ Number::currency($sale->original_total, 'IDR', 'id', 0) }}</td>
            </tr>
            <tr>
                <td class="w-2/5 py-2 my-3">total akhir</td>
                <td class="w-3/5 py-2 my-3">: {{ Number::currency($sale->grand_total, 'IDR', 'id', 0) }}</td>
            </tr>
            <tr>
                <td class="w-2/5 py-2 my-3">diskon</td>
                <td class="w-3/5 py-2 my-3">: {{ Number::currency(($sale->original_total - $sale->grand_total), 'IDR',
                    'id', 0) }}
                </td>
            </tr>
            <tr>
                <td class="w-2/5 py-2 my-3">total bayar</td>
                <td class="w-3/5 py-2 my-3">: {{ Number::currency($sale->payment, 'IDR', 'id', 0) }}</td>
            </tr>
            <tr>
                <td class="w-2/5 py-2 my-3">Kembalian</td>
                <td class="w-3/5 py-2 my-3">: {{ Number::currency($sale->change, 'IDR', 'id', 0) }}</td>
            </tr>
        </table>
    </x-card>
    <x-card title="List Produk transaksi">
        <x-table :headers="$headers" :rows="$sale->saleDetails">
            @scope('cell_id', $detail)
            {{ 1 + $loop->index}}
            @endscope
            @scope('cell_product.price', $detail)
            {{ Number::currency($detail->product->price, 'IDR', 'id', 0) }}
            @endscope
            @scope('cell_subTotal', $detail)
            {{ Number::currency($detail->subTotal, 'IDR', 'id', 0) }}
            @endscope
        </x-table>
    </x-card>
</div>