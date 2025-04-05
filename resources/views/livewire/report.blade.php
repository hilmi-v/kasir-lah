<div>
    <x-header title="Buat Laporan" separator progress-indicator>
        <x-slot:actions>
            {{ now()->locale('id')->isoFormat('dddd DD-MM-Y') }}
        </x-slot:actions>
    </x-header>

    <x-datepicker label="Range" wire:model.live="date" icon="o-calendar" :config="$config2"
        hint="(optional) jika tidak di isi maka akan mendownload seluruh transaksi" />
    <x-button label="Download" @click="$wire.export" spinner="export" class="btn-neutral w-full text-white mt-4">
    </x-button>


</div>