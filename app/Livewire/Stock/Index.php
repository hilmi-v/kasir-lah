<?php

namespace App\Livewire\Stock;

use Mary\Traits\Toast;
use App\Models\Product;
use App\Models\StockLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use Toast;
    public bool $modal = false;
    public string $search = '';
    public array $sortBy = ['column' => 'stock', 'direction' => 'asc'];
    public $stock;
    public function decoration()
    {
        return [
            'stock' => [
                'bg-warning text-white' => fn($cell) => $cell['stock'] > 10 && $cell['stock'] <= 20,
                'bg-error text-white' => fn($cell) => $cell['stock'] <= 10,
            ]
        ];
    }

    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'font-bold text-black dark:text-white w-7', 'sortable' => false],
            ['key' => 'name', 'label' => 'Name', 'class' => "w-40"],
            ['key' => 'stock', 'label' => 'Stok', 'class' => "w-10"],
        ];
    }
    public function products()
    {
        return Product::with('category')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }

    public function update(Product $id)
    {
        $log = new StockLog();
        $log->product_id = $id->id;
        $log->before = $id->stock;
        $id->update(['stock' => $this->stock + $id->stock]);
        $log->after = $id->stock;
        $log->description = "tambah stok";
        $log->save();
        $this->success('Stock updated successfully', position: 'toast-bottom');
        $this->modal = false;


    }
    public function render()
    {
        return view('livewire.stock.index', [
            'products' => $this->products(),
            'headers' => $this->headers(),
            'decoration' => $this->decoration(),
        ]);
    }
}
