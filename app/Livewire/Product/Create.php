<?php

namespace App\Livewire\Product;

use Mary\Traits\Toast;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;

class Create extends Component
{
    use Toast;
    public $name;
    public $price;
    public $stock;
    public $category;
    public function categories()
    {
        return Category::all();
    }

    public function store()
    {
        $this->price = intval(str_replace('.', '', $this->price));
        $this->stock = intval(str_replace('.', '', $this->stock));

        $this->validate([
            'name' => 'required|unique:products,name',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|exists:categories,id'
        ]);

        $product = Product::create([
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => $this->category
        ]);
        $this->success('Product created successfully', position: 'toast-bottom', redirectTo: route('products.index'));

    }

    public function render()
    {
        return view('livewire.product.create', [
            'categories' => $this->categories()
        ]);
    }
}
