<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;
#[Title('Edit Transaksi')]
class Edit extends Component
{
    use Toast;
    public Category $category;
    public string $name;
    public function mount(Category $id)
    {
        $this->category = $id;
        $this->name = $id->name;
    }

    public function update()
    {
        $this->validate(([
            'name' => 'required|min:3|unique:categories,name,' . $this->category->id
        ]));

        $this->category->name = $this->name;
        $this->category->save();
        $this->toast('Category updated successfully', 'success', position: 'toast-bottom', redirectTo: route('categories.index'));
    }
    public function render()
    {
        return view('livewire.category.edit');
    }
}
