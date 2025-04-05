<div>
    <x-header title="history stok" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>
    <x-button icon="bi.arrow-left" class="mb-4 btn-neutral btn-sm " label="kembali" link="{{ route('stock.index') }}" />
    <x-card>
        <x-table :headers=" $headers" :rows="$logs" with-pagination show-empty-text :sort-by="$sortBy">
            @scope('cell_id', $log, $logs)
            {{ $logs->firstItem() + $loop->index}}
            @endscope
            @scope('cell_created_at', $log, $logs)
            {{ $log->created_at->locale('id')->isoFormat('DD-MM-Y') }}
            @endscope
        </x-table>
    </x-card>
</div>