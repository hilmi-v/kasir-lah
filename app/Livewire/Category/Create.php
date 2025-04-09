<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;
#[Title('Create Category')]
class Create extends Component
{
    use Toast;
    public string $name;

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3|unique:categories,name'
        ]);
        Category::create([
            'name' => $this->name
        ]);

        $this->toast('success', 'Category created successfully', redirectTo: route('categories.index'), position: 'toast-bottom');
    }
    public function render()
    {
        return view('livewire.category.create');
    }
}
