<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DetailModal extends Component
{
    public $purchase;
    public $attachment;
    public $ext;

    protected $listeners = ['setPurchase'];
    protected $rules = [
        'purchase.keterangan' => 'nullable',
    ];

    public function setPurchase($id)
    {
        $this->purchase = Purchase::find($id);
        $attachment = $this->purchase?->attachments()?->where('tag', 'BUKTI_PEMBAYARAN')->first();
        $this->ext = explode('.', $attachment?->attachment_name);
        $this->attachment = $attachment ? Storage::url($attachment?->attachment) : null;
    }

    public function approve()
    {
        $this->purchase->status = 'Approved';
        $this->purchase->save();

        $this->emitUp('reset');

        return session()->flash('success', 'Order request accepted');
    }

    public function reject()
    {
        $this->purchase->status = 'Rejected';
        $this->purchase->save();

        $this->emitUp('reset');

        return session()->flash('success', 'Order request rejected');
    }

    public function orderAndPay()
    {
        $this->purchase->status = 'Purchasing';
        $this->purchase->save();

        $this->emitUp('reset');

        return session()->flash('success', 'Order request sent to supplier');
    }

    public function print()
    {
        return redirect()->route('orders.print', ['id' => $this->purchase->pembelian_id]);
    }

    public function generatePdf()
    {
        $request = Purchase::with('orderList', 'orderList.medicine', 'supplier')->find($this->purchase->pembelian_id);
        $filename = Carbon::now()->format('Y-m-d') . '_REQUEST_PEMBELIAN.pdf';
        $pdf = Pdf::loadView('pdf.request', ['request' => $request, 'tanggal' => Carbon::now()->format('Y-m-d')])->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $filename,
        );
    }

    public function render()
    {
        return view('livewire.stocks.detail-modal');
    }
}
