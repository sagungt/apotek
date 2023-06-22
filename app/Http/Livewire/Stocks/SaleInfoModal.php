<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Sell;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class SaleInfoModal extends Component
{
    public $sale;

    protected $listeners = ['setSale'];

    public function setSale($id)
    {
        $sale = Sell::with(['orderList', 'orderList.medicine', 'orderList.medicine.medicine'])->find($id);
        $this->sale = $sale;
    }

    public function print()
    {
        return redirect()->route('sales.print', ['id' => $this->sale->penjualan_id]);
    }

    public function downloadPdf()
    {
        $filename = $this->sale->tanggal . '_' . $this->sale->no_faktur . '.pdf';
        $pdf = Pdf::loadView('pdf.invoice', $this->sale->toArray())->output();
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
