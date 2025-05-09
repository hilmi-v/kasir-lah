<div>
    <x-header title="Tambah Product" progress-indicator>
    </x-header>
    <x-button class="btn-sm btn-neutral mb-5" icon="bi.arrow-left" label="kembali"
        link="{{ route('products.index') }}" />
    <x-card>
        <x-form wire:submit="store">
            <x-input placeholder="masukkan nama produk" label="Nama Produk" required wire:model="name"></x-input>
            <x-input placeholder="masukkan harga jual " label="Harga Produk" required wire:model="price"
                x-mask:dynamic="$money($input,',','.',0)" prefix="Rp"></x-input>
            <x-input placeholder="stok produk " label="masukkan stok Produk" required wire:model="stock"
                x-mask:dynamic="$money($input,',','.',0)"></x-input>
            <x-choices-offline label="pilih kategori" :options="$categories" placeholder="kategori" single searchable
                required wire:model="category" />
            <x-button label="tambah" class="btn-success" type="submit" spinner="store" />
        </x-form>
    </x-card>


</div>