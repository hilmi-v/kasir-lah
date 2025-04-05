<div x-data="{id: null, stock : 0 }">
    <x-header title="Produk" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>
    <x-button icon="bi.clock-history" class="mb-4 btn-neutral btn-sm " label="histori stok"
        link="{{ route('stock.log') }}" />
    <x-card>
        <x-table :headers=" $headers" :rows="$products" with-pagination show-empty-text :sort-by="$sortBy" no-hover
            :cell-decoration="$decoration">
            @scope('cell_id', $product, $products)
            {{ $products->firstItem() + $loop->index}}
            @endscope
            @scope('cell_stock', $product)
            {{ Number::format($product->stock, 0, 0, 'id-ID') }}
            @endscope
            @scope('actions', $product)
            <div class="flex mb-2 space-x-2">
                <x-button class="btn-warning btn-sm text-white" label="tambah stock"
                    @click="$wire.modal = true; id = {{ $product->id }}; stock = {{ $product->stock }}" spinner />
            </div>
            @endscope
        </x-table>
    </x-card>


    <x-modal wire:model="modal" box-class=" p-5" title="Tambah Stock">
        <x-input placeholder="Tambah stok barang" label="Harga Produk" required wire:model="stock"
            x-mask:dynamic="$money($input,',','.',0)" hint="note : stok saat ini + stok tambahan dari input">
            <x-slot:prefix>
                <span x-text="stock"></span> +
            </x-slot:prefix>
        </x-input>
        <x-slot:actions>
            <x-button label="Simpan" class="btn-primary btn-sm" @click="$wire.update(id); id = null;" />
        </x-slot:actions>
    </x-modal>
</div>