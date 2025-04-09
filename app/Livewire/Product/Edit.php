<?php

namespace App\Livewire\Product;

use Mary\Traits\Toast;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Title;
#[Title('Edit Produk')]
class Edit extends Component
{
    use Toast;
    public $name;
    public $price;
    public $stock;
    public $category;
    public Product $product;
    public function mount(Product $id)
    {
        $this->product = $id;
        $this->name = $id->name;
        $this->price = $id->price;
        $this->stock = $id->stock;
        $this->category = $id->category_id;
    }

    public function categories()
    {
        return Category::all();
    }

    public function update()
    {
        $this->price = intval(str_replace('.', '', $this->price));
        $this->stock = intval(str_replace('.', '', $this->stock));

        $this->validate([
            'name' => 'required|unique:products,name,' . $this->product->id,
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|exists:categories,id'
        ]);

        $this->product->update([
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => $this->category
        ]);

        $this->success('Product created successfully', position: 'toast-bottom', redirectTo: route('products.index'));

    }
    public function render()
    {
        return view('livewire.product.edit', [
            'categories' => $this->categories()
        ]);
    }
}
