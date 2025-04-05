<?php

namespace App\Livewire\Transaction;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Index extends Component
{
    use WithPagination;

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];
    public function sales()
    {
        return Sale::orderBy($this->sortBy['column'], $this->sortBy['direction'])->paginate(10);
    }

    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'font-bold text-black dark:text-white w-7', 'sortable' => false],
            ['key' => 'grand_total', 'label' => 'total transaksi'],
            ['key' => 'created_at', 'label' => 'tanggal transaksi'],
        ];
    }
    public function render()
    {
        return view(
            'livewire.transaction.index',
            [
                'sales' => $this->sales(),
                'headers' => $this->headers()
            ]
        );
    }
}
