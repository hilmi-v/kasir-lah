<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;
#[Title('Kategori')]
class Index extends Component
{
    use WithPagination;
    use Toast;
    public string $search = '';
    public bool $modal = false;
    public function categories()
    {
        return Category::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);
    }

    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'font-bold text-black dark:text-white w-7'],
            ['key' => 'name', 'label' => 'Name'],
        ];
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        $this->toast('Category deleted successfully', 'success', position: 'toast-bottom');
        $this->modal = false;
    }
    public function render()
    {
        return view('livewire.category.index', [
            'categories' => $this->categories(),
            'headers' => $this->headers()
        ]);
    }
}
