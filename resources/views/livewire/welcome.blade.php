<div>
    <x-header title="Dashboard" subtitle=" {{ now()->locale('id')->isoFormat('dddd DD-MM-Y') }}" separator
        progress-indicator>
        <x-slot:actions>
            <x-select icon="bi.calendar" :options="$options" wire:model.live="selected" />
        </x-slot:actions>
    </x-header>

    <div class="grid grid-cols-3 gap-4 mb-6">
        <x-stat title="Produk" value="{{ $totalProduct }}" icon="bi.box" color="text-primary" shadow
            description="terjual" />
        <x-stat title="transaksi" value="{{ $totalTransaction }}" icon="bi.cart" color="text-warning" shadow
            description=" transaksi terjadi" />
        <x-stat title="Penjualan" value="{{ Number::currency($totalSales, 'IDR', 'id-ID',0 ) }}" icon="bi.cash"
            description="total penjualan" color="text-secondary" shadow />
    </div>


    <div class="grid grid-cols-8 gap-7 justify-center  max-h-1/5 mb-5">
        <x-card class="col-span-5 h-full " title="penjualan" separator shadow>
            <x-chart wire:model="salesChart" />
        </x-card>
        <x-card class="col-span-3 h-full" title="kategori" separator shadow>
            <x-chart wire:model="categoryChart" />
        </x-card>
    </div>

    <div class="grid grid-cols-2 gap-7">
        <x-card title="Transaksi terakhir">
            <x-slot:menu>
                <x-button icon-right="bi.arrow-right" link="{{ route('transactions.index') }}"
                    class="btn-ghost btn btn-sm" type="button" label="transaksi" />
            </x-slot:menu>
            <x-table :headers=" $transactionsHeaders" :rows="$transactions" show-empty-text>
                @scope('cell_id', $transaction)
                {{ 1 + $loop->index}}
                @endscope
                @scope('cell_grand_total', $transaction)
                {{ Number::currency($transaction->grand_total, 'IDR', 'id-ID', 0) }}
                @endscope
                @scope('cell_created_at', $transaction)
                {{ $transaction->created_at->locale('id')->isoFormat('dddd DD-MM-Y') }}
                @endscope
            </x-table>
        </x-card>
        <x-card title="best seller">
            <x-slot:menu>
                <x-button icon-right="bi.arrow-right" link="{{ route('products.index') }}" class="btn-ghost btn btn-sm"
                    type="button" label="produk" />
            </x-slot:menu>
            <x-table :headers=" $productsHeaders" :rows="$products" show-empty-text>
                @scope('cell_id', $product)
                {{ 1 + $loop->index}}
                @endscope

            </x-table>
        </x-card>

    </div>
</div>