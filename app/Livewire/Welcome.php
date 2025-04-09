<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Attributes\Title;
use Mary\Traits\Toast;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
#[Title('Dashboard')]
class Welcome extends Component
{
    use Toast;
    public $selected = 30;

    public array $salesChart;
    public array $categoryChart;
    public function transactions()
    {
        return Sale::latest()
            ->take(5)
            ->get();
    }
    public function transactionsHeaders()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'font-bold text-black dark:text-white w-7'],
            ['key' => 'grand_total', 'label' => 'total transaksi'],
            ['key' => 'created_at', 'label' => 'tanggal transaksi'],
        ];
    }
    public function products()
    {
        return SaleDetail::with('product')
            ->where('created_at', '>=', now()->subDays($this->selected))
            ->get()
            ->groupBy('product.name')
            ->map(function ($item) {
                return [
                    'name' => $item->first()->product->name,
                    'total' => $item->sum('quantity'),
                ];
            })
            ->sortBy('total', SORT_REGULAR, true)
            ->take(5)
            ->values();
    }
    public function productsHeaders()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'font-bold text-black dark:text-white w-7'],
            ['key' => 'name', 'label' => 'nama produk'],
            ['key' => 'total', 'label' => 'total terjual'],
        ];
    }

    public function totalProduct()
    {
        return SaleDetail::where('created_at', '>=', now()->subDays($this->selected))->
            sum('quantity');
    }
    public function totalTransaction()
    {
        return Sale::where('created_at', '>=', now()->subDays($this->selected))->
            count();
    }
    public function totalSales()
    {
        return Sale::where('created_at', '>=', now()->subDays($this->selected))->
            sum('grand_total');
    }
    public function render()
    {
        $options = [
            ['id' => 7, 'name' => '7 hari terakhir'],
            ['id' => 15, 'name' => '15 hari terakhir'],
            ['id' => 30, 'name' => '30 hari terakhir'],
            ['id' => 999999999999, 'name' => 'semua'],
        ];


        $salesData = Sale::selectRaw('DATE(created_at) as date, SUM(grand_total) as total')
            ->where('created_at', '>=', now()->subDays($this->selected))
            ->orderBy('date')
            ->groupBy('date')
            ->get();
        $this->salesChart = [
            'type' => 'line',
            'data' =>
                [
                    'labels' => $salesData->pluck('date'),
                    'datasets' => [
                        [
                            'label' => 'rupiah',
                            'fill' => true,
                            'data' => $salesData->pluck('total'),
                        ]
                    ],
                ],
            'options' => [
                // 'responsive' => true,
                // 'maintainAspectRatio' => false,
                "backgroundColor" => "#dfd7f7",
                'scales' => [
                    'x' => [
                        'display' => false,
                    ],
                ],
                "plugins" => [
                    'legend' => [
                        'display' => false,
                    ]
                ]
            ],
        ];

        $categoryData = SaleDetail::with('product.category')
            ->where('created_at', '>=', now()->subDays($this->selected))
            ->get()
            ->groupBy('product.category.name')
            ->map(function ($item) {
                return [
                    'category' => $item->first()->product->category->name,
                    'total' => $item->sum('quantity'),
                ];
            })
            ->values();

        $this->categoryChart = [
            'type' => 'doughnut',
            'data' =>
                [
                    'labels' => $categoryData->pluck('category'),
                    'datasets' => [
                        [
                            'label' => 'terjual',
                            // 'fill' => true,
                            'data' => $categoryData->pluck('total'),
                        ]
                    ],
                ],
            'options' => [
                // 'responsive' => true,
                // 'maintainAspectRatio' => false,
                "plugins" => [
                    'legend' => [
                        'position' => 'bottom',
                    ]

                ]
            ],
        ];




        return view('livewire.welcome', [
            'options' => $options,
            'totalProduct' => $this->totalProduct(),
            'totalTransaction' => $this->totalTransaction(),
            'totalSales' => $this->totalSales(),
            'transactions' => $this->transactions(),
            'transactionsHeaders' => $this->transactionsHeaders(),
            'products' => $this->products(),
            'productsHeaders' => $this->productsHeaders(),
        ]);
    }
}
