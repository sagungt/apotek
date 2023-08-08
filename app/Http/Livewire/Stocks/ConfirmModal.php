<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Purchase;
use App\Models\Stock;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConfirmModal extends Component
{
    use WithFileUploads;

    public $purchase;
    public $orders;
    public $attachment;
    public $qty = [];

    protected $listeners = ['setPurchase'];

    protected $rules = [
        'purchase.no_faktur'      => 'required',
        'purchase.keterangan'     => 'nullable',
        'purchase.tanggal_terima' => 'required|date',
        'purchase.total'          => 'required|numeric',
        'orders.*.no_batch'       => 'required',
        'orders.*.no_exp'         => 'required|date',
        'orders.*.harga_jual'     => 'required|numeric',
        'qty.*'                   => 'required|numeric',
        'attachment'              => 'required|file|mimes:jpg,png,pdf'
    ];

    public function setPurchase($id)
    {
        $this->purchase = Purchase::with('orderList')->find($id);
        $this->orders = $this->purchase->orderList;
        foreach ($this->orders as $index => $order) {
            $this->orders[$index]->harga_jual = $order->total / ($order->kuantitas * ($order->medicine->isi_box ?? 1));
            $this->qty[$index] = $order->kuantitas * ($order->medicine->isi_box ?? 1);
        }
    }

    public function confirm()
    {
        $this->validate();

        foreach ($this->orders as $index => $order) {
            Stock::create([
                'obat_id'    => $order->medicine->obat_id,
                'stok'       => $this->qty[$index],
                'harga_jual' => $order->harga_jual,
                'no_batch'   => $order->no_batch,
                'no_exp'     => $order->no_exp,
                'status'     => 'Active'
            ]);

            unset($order->no_batch);
            unset($order->no_exp);
            unset($order->harga_jual);

            $order->status = 'Complete';
            $order->save();
        }

        if ($this->attachment) {
            $path = 'files';
            $name = $this->attachment->getClientOriginalName();
            $this->attachment->storeAs($path, $name);
            $this->purchase->attachments()
                ->create([
                    'tag' => 'BUKTI_PEMBAYARAN',
                    'attachment' => "$path/$name",
                    'attachment_name' => $name,
                ]);
        }

        $this->purchase->status = 'Complete';
        $this->purchase->save();

        $this->emitUp('reset');

        return session()->flash('success', 'Order completed');
    }

    public function render()
    {
        return view('livewire.stocks.confirm-modal');
    }
}
