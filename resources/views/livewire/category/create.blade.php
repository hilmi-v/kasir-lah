<div>
    <x-header title="Tambah Kategori" progress-indicator>
    </x-header>
    <x-button class="btn-sm btn-neutral" icon="bi.arrow-left" label="kembali" link="{{ route('categories.index') }}" />
    <x-form class="mt-5 bg-base-100 rounded-xl p-4" wire:submit='store'>
        <x-input label="Nama Kategori" placeholder="masukkan nama kategori" required wire:model="name" />
        <x-button label="Tambah" class="btn-success text-white" spinner="store" type="submit" />
    </x-form>
</div>