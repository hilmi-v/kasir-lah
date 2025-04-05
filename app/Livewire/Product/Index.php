<?php

namespace App\Livewire\Product;

use Mary\Traits\Toast;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use Toast;
    public bool $modal = false;
    public string $search = '';
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];


    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'font-bold text-black dark:text-white w-7'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'price', 'label' => 'Harga'],
            ['key' => 'stock', 'label' => 'Stok'],
            ['key' => 'category.name', 'label' => 'kategori'],
        ];
    }
    public function products()
    {
        return Product::with('category')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }

    public function delete(Product $id)
    {
        $id->delete();
        $this->modal = false;
        $this->success('Product deleted successfully', position: 'toast-bottom');
    }
    public function render()
    {
        return view('livewire.product.index', [
            'products' => $this->products(),
            'headers' => $this->headers(),
        ]);
    }
}
