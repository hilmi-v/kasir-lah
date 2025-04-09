<?php

namespace App\Livewire\Stock;

use App\Models\StockLog;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
#[Title('Log Stok')]
class Log extends Component
{
    use WithPagination;
    public string $search = '';
    public array $sortBy = ['column' => 'created_at', 'direction' => 'asc'];

    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'font-bold text-black dark:text-white w-7', 'sortable' => false],
            ['key' => 'product.name', 'label' => 'produk'],
            ['key' => 'before', 'label' => 'sebelum', 'sortable' => false],
            ['key' => 'after', 'label' => 'sesudah', 'sortable' => false],
            ['key' => 'description', 'label' => 'deskripsi', 'sortable' => false],
            ['key' => 'created_at', 'label' => 'tanggal'],
        ];
    }
    public function logs()
    {
        return StockLog::with('product')
            ->where('description', 'like', '%' . $this->search . '%')
            ->orWhereHas('product', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }
    public function render()
    {
        return view('livewire.stock.log', [
            'logs' => $this->logs(),
            'headers' => $this->headers()
        ]);
    }
}
