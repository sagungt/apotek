<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Sell;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class SaleInfoModal extends Component
{
    public $sale;
    public $name;

    protected $listeners = ['setSale'];

    public function setSale($id)
    {
        $sale = Sell::with(['orderList', 'orderList.medicine', 'orderList.medicine.medicine'])->find($id);
        $this->sale = $sale;
    }

    public function print()
    {
        $this->validate(['name' => 'required']);
        return redirect()->route('sales.print', ['id' => $this->sale->penjualan_id, 'name' => $this->name]);
    }

    public function downloadPdf()
    {
        $this->validate(['name' => 'required']);
        $filename = $this->sale->tanggal . '_' . $this->sale->no_faktur . '.pdf';
        $pdf = Pdf::loadView('pdf.invoice', [...$this->sale->toArray(), 'name' => $this->name, 'now' => Carbon::now()->format('Y-m-d')])->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $filename,
        );
    }

    public function render()
    {
        return view('livewire.stocks.sale-info-modal');
    }
}
