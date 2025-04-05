<?php

namespace App\Livewire;

use App\Exports\SaleReport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Report extends Component
{
    public $config2 = ['mode' => 'range', 'altFormat' => 'd F Y'];
    public $date = null;
    public function export()
    {
        return Excel::download(new SaleReport($this->date), 'laporan-penjualan-' . date('d-m-Y') . '.xlsx');
    }


    public function render()
    {
        return view('livewire.report');
    }
}
