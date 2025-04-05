<div x-data="{id: null }">
    <x-header title="Kategori" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>
    <x-button icon="bi.plus" class="btn-primary btn-sm mb-4" label="tambah Kategori"
        link="{{ route('categories.create') }}" />
    <x-card>
        <x-table :headers=" $headers" :rows="$categories" with-pagination show-empty-text>
            @scope('cell_id', $category, $categories)
            {{ $categories->firstItem() + $loop->index}}
            @endscope
            @scope('actions', $category)
            <div class="flex mb-2 space-x-2">
                <x-button class="btn-warning btn-sm" label="edit"
                    link="{{ route('categories.edit', $category->id) }}" />
                <x-button class="btn-error btn-sm" label="delete" @click="$wire.modal = true, id = {{ $category->id }}"
                    spinner />
            </div>
            @endscope
        </x-table>
    </x-card>
    <x-modal wire:model="modal" box-class="w-fit">
        <div class="flex flex-col items-center justify-center mb-1">
            <x-icon name="bi.exclamation-circle" class="text-error w-12 h-12 font-bold" />
            <p> hapus kategori ini?</p>
        </div>
        <x-slot:actions>
            <x-button label="Cancel" class="btn-ghost btn-sm" @click="$wire.myModal1 = false" />
            <x-button label="Hapus" class="btn-outline btn-sm " @click="$wire.delete(id)" />
        </x-slot:actions>
    </x-modal>
</div>