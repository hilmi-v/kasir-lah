<div>
    <x-header title="Transaksi" separator progress-indicator>
    </x-header>
    <x-button icon="bi.plus" class="btn-primary btn-sm mb-4" label="Mulai transaksi"
        link="{{ route('transactions.create') }}" />
    <x-card>
        <x-table :headers=" $headers" :rows="$sales" show-empty-text with-pagination :sort-by="$sortBy">
            @scope('cell_id', $sale, $sales)
            {{ $sales->firstItem() + $loop->index}}
            @endscope
            @scope('cell_grand_total', $sale)
            {{ Number::currency($sale->grand_total, 'IDR', 'id-ID', 0) }}
            @endscope
            @scope('cell_created_at', $sale)
            {{ $sale->created_at->locale('id')->isoFormat('dddd DD-MM-Y') }}
            @endscope
            @scope('actions', $sale)
            <x-button label="detail" class="btn-primary btn-sm" link="{{ route('transactions.detail', $sale->id) }}" />
            @endscope
        </x-table>
    </x-card>

</div>