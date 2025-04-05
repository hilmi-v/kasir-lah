<?php

namespace App\Livewire\Transaction;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;
    public array $cart = [];
    public $selected;
    public $payment = 0;
    public $change = 0;
    public $original_total = 0;
    public $grand_total = 0;

    public bool $modal = false;
    public bool $discount = false;
    public function products()
    {
        return Product::where('stock', '>', 1)->get(['id', 'name']);
    }

    public function addCart()
    {
        if ($this->selected !== null) {
            $product = Product::find($this->selected);

            if ($product && $product->stock > 0) {
                $index = array_search($product->id, array_column($this->cart, 'product_id'));

                if ($index !== false) {
                    if ($this->cart[$index]['quantity'] < $this->cart[$index]['stock']) {
                        $this->cart[$index]['quantity'] += 1;
                        $this->cart[$index]['subTotal'] += $this->cart[$index]['price'];
                    } else {
                        $this->error('stock tidak cukutp');
                    }
                } else {
                    $this->cart[] = [
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'subTotal' => $product->price,
                        'quantity' => 1
                    ];
                }
            }
        }
        $this->calculateTotal();
        $this->reset('selected');
    }

    public function increment($id)
    {
        $index = array_search($id, array_column($this->cart, 'product_id'));
        if ($this->cart[$index]['quantity'] < $this->cart[$index]['stock']) {
            $this->cart[$index]['quantity'] += 1;
            $this->cart[$index]['subTotal'] += $this->cart[$index]['price'];
            $this->calculateTotal();
        } else {
            $this->error('stock tidak cukutp');
        }
    }
    public function decrement($id)
    {
        $index = array_search($id, array_column($this->cart, 'product_id'));
        if ($this->cart[$index]['quantity'] > 1) {
            $this->cart[$index]['quantity'] -= 1;
            $this->cart[$index]['subTotal'] -= $this->cart[$index]['price'];
            $this->calculateTotal();
        }
    }

    public function delete($id)
    {
        $index = array_search($id, array_column($this->cart, 'product_id'));
        array_splice($this->cart, $index, 1);
        $this->calculateTotal();
    }
    public function calculateTotal()
    {
        $this->original_total = array_sum(array_column($this->cart, 'subTotal'));
        $this->grand_total = $this->original_total;
    }

    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'font-bold text-black dark:text-white w-7', 'sortable' => false],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'price', 'label' => 'Harga'],
            ['key' => 'quantity', 'label' => 'Jumlah'],
            ['key' => 'subTotal', 'label' => 'subtotal']
        ];
    }

    public function updatedPayment()
    {
        $payment = str_replace('.', '', $this->payment);
        $grand_total = str_replace('.', '', $this->grand_total);
        if ($payment != null && $grand_total != null) {
            $this->change = $payment - $grand_total;
        }
    }

    public function updatedGrandTotal()
    {
        $this->updatedPayment();
    }
    public function startPayment()
    {
        $this->modal = true;
        $this->change = $this->payment - $this->grand_total;

    }

    public function store()
    {
        $sale = Sale::create([
            'original_total' => $this->original_total,
            'grand_total' => str_replace('.', '', $this->grand_total),
            'payment' => str_replace('.', '', $this->payment),
            'change' => $this->change
        ]);

        foreach ($this->cart as $key => $value) {
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $value['product_id'],
                'quantity' => $value['quantity'],
                'subTotal' => $value['subTotal']
            ]);

            $product = Product::find($value['product_id']);
            $product->stock -= $value['quantity'];
            $product->save();
        }
        $this->success('Transaction created successfully', position: 'toast-bottom', redirectTo: route('transactions.index'));
    }
    public function render()
    {
        return view(
            'livewire.transaction.create',
            [
                'products' => $this->products(),
                'headers' => $this->headers()
            ]
        );
    }
}
