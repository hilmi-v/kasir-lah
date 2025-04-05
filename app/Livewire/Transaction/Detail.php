<?php

namespace App\Livewire\Transaction;

use App\Models\Sale;
use Livewire\Component;

class Detail extends Component
{
    public $sale;
    public function mount($id)
    {
        $this->sale = Sale::with('saleDetails.product', 'saleDetails')->find($id);
    }
    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'font-bold text-black dark:text-white w-7'],
            ['key' => 'product.name', 'label' => 'nama'],
            ['key' => 'product.price', 'label' => 'harga'],
            ['key' => 'quantity', 'label' => 'jumlah'],
            ['key' => 'subTotal', 'label' => 'subtotal'],
        ];
    }
    public function render()
    {
        return view('livewire.transaction.detail', [
            'headers' => $this->headers()
        ]);
    }
}
