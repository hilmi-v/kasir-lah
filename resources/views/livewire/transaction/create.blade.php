<div x-data="discount : false">
    <x-header title="Transaksi" separator progress-indicator>
        <x-slot:actions>
            {{ now()->locale('id')->isoFormat('dddd DD-MM-Y') }}
        </x-slot:actions>
    </x-header>
    <x-button class="btn-sm btn-neutral mb-4" icon="bi.arrow-left" label="kembali"
        link="{{ route('transactions.index') }}" />
    <div class="grid grid-cols-12 gap-7">
        <x-card class="col-span-8 row-span-7">
            <x-form wire:submit='addCart'>
                <x-choices-offline wire:model="selected" :options="$products" placeholder="cari produk" single
                    searchable icon="bi.box" class="mb-5" required>
                    <x-slot:append>
                        <x-button icon="o-plus" class="join-item btn-primary" type="submit" spinner="addCart" />
                    </x-slot:append>
                </x-choices-offline>
            </x-form>
            <x-table :headers=" $headers" :rows="$cart" show-empty-text empty-text="Transaksi kosong">
                @scope('cell_id', $cart)
                {{ $loop->index + 1 }}
                @endscope
                @scope('cell_price', $cart)
                {{ Number::currency($cart['price'], 'IDR', 'id-ID',0 ) }}
                @endscope
                @scope('cell_quantity', $cart)
                <div class="flex gap-1">
                    <x-button icon="bi.dash" class="btn-square btn-xs btn-primary"
                        @click="$wire.decrement({{ $cart['product_id'] }})" />
                    <span>{{ $cart['quantity'] }}</span>
                    <x-button icon="bi.plus" class="btn-square btn-xs btn-primary"
                        @click="$wire.increment({{ $cart['product_id'] }})" />
                </div>
                @endscope
                @scope('cell_subTotal', $cart)
                {{ Number::currency($cart['subTotal'], 'IDR', 'id-ID',0 ) }}
                @endscope
                @scope('actions', $cart)
                <x-button class="btn-warning btn-sm text-white" label="hapus" type="button"
                    @click="$wire.delete({{ $cart['product_id'] }})" />
                @endscope
            </x-table>
        </x-card>
        <x-card class="col-span-4 " title="Total transaksi">
            {{ Number::currency($original_total, 'IDR', 'id-ID',0 ) }}
        </x-card>

        <x-button class="col-start-9 col-end-13 mt-5 btn-accent" label="bayar" @click="$wire.startPayment"
            x-bind:disabled="$wire.cart.length == 0" />
    </div>
    <x-modal wire:model="modal" title="Konfirmasi Transaksi" separator>
        <p class="text-sm mb-2">total asli = {{ Number::currency($original_total, 'IDR', 'id-ID',0 ) }}</p>
        <x-input label="Nominal" hint="note : ubah total transaksi untuk memberi diskon" wire:model.live="grand_total"
            x-bind:disabled="!$wire.discount" x-mask:dynamic="$money($input,',','.',0)" prefix="Rp" class="mb-2">
        </x-input>
        <x-checkbox label="beri diskon" wire:model="discount" class="mb-4" />
        <x-input label="Nominal Pembayaran" wire:model.live="payment" x-mask:dynamic="$money($input,',','.',0)"
            prefix="Rp" class="mb-2">
        </x-input>
        <p class="text-sm mt-2">Kembalian = {{ Number::currency($change, 'IDR', 'id-ID',0 ) }}</p>
        <x-slot:actions>
            <x-button label="bayar" class="btn-outline btn-sm btn-accent w-full" spinner
                x-bind:disabled="$wire.change < 0" @click="$wire.store" />
        </x-slot:actions>
    </x-modal>
</div>
