<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SaleReport implements FromView, ShouldAutoSize
{
    public $date;
    public $startDate = null;
    public $endDate = null;
    public function __construct($date = null)
    {
        $this->date = $date;
    }
    public function view(): View
    {
        if ($this->date) {
            list($this->startDate, $this->endDate) = explode(' - ', $this->date);

            $this->startDate = Carbon::parse($this->startDate);
            $this->endDate = Carbon::parse($this->endDate);

            $sales = Sale::with('saleDetails', 'saleDetails.product')
                ->whereDate('created_at', '>=', $this->startDate->format('Y-m-d'))
                ->whereDate('created_at', '<=', $this->endDate->format('Y-m-d'))
                ->orderBy('created_at')
                ->get();
        } else {
            $sales = Sale::with('saleDetails', 'saleDetails.product')
                ->orderBy('created_at')
                ->get();
        }

        $products = [];
        foreach ($sales as $sale) {
            foreach ($sale->saleDetails as $detail) {
                $Index = array_search($detail->product_id, array_column($products, 'product_id'));
                if ($Index !== false) {
                    $products[$Index]['quantity'] += $detail->quantity;
                    $products[$Index]['subTotal'] += $detail->subTotal;
                } else {
                    $products[] = [
                        'product_id' => $detail->product_id,
                        'name' => $detail->product->name,
                        'price' => $detail->product->price,
                        'quantity' => $detail->quantity,
                        'subTotal' => $detail->subTotal,
                    ];
                }
            }
        }

        $products = collect($products);
        return view('exports.sale', [
            'products' => $products,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'sales' => $sales
        ]);
    }
}
