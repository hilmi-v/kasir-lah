<div x-data="{id: null }">
    <x-header title="Produk" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>

    <x-button icon="bi.plus" class="btn-primary btn-sm mb-4" label="tambah produk"
        link="{{ route('products.create') }}" />
    <x-card>
        <x-table :headers=" $headers" :rows="$products" with-pagination show-empty-text :sort-by="$sortBy">
            @scope('cell_id', $product, $products)
            {{ $products->firstItem() + $loop->index}}
            @endscope
            @scope('cell_price', $product)
            {{ Number::currency($product->price, 'IDR', 'id-ID', 0) }}
            @endscope
            @scope('cell_stock', $product)
            {{ Number::format($product->stock, 0, 0, 'id-ID') }}
            @endscope
            @scope('actions', $product)
            <div class="flex mb-2 space-x-2">
                <x-button class="btn-warning btn-sm" label="edit" link="{{ route('products.edit', $product->id) }}" />
                <x-button class="btn-error btn-sm" label="delete" @click="$wire.modal = true, id = {{ $product->id }}"
                    spinner />
            </div>
            @endscope
        </x-table>
    </x-card>


    <x-modal wire:model="modal" box-class="w-fit">
        <div class="flex flex-col items-center justify-center mb-1">
            <x-icon name="bi.exclamation-circle" class="text-error w-12 h-12 font-bold" />
            <p> hapus Produk ini?</p>
        </div>
        <x-slot:actions>
            <x-button label="Cancel" class="btn-ghost btn-sm" @click="$wire.myModal1 = false, id = null" />
            <x-button label="Hapus" class="btn-outline btn-sm " @click="$wire.delete(id), id = null" />
        </x-slot:actions>
    </x-modal>
</div>