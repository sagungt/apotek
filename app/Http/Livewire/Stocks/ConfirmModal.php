<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Purchase;
use App\Models\Stock;
use Livewire\Component;

class ConfirmModal extends Component
{
    public $purchase;
    public $orders;

    protected $listeners = ['setPurchase'];

    protected $rules = [
        'purchase.no_faktur' => 'required',
        'purchase.keterangan' => 'nullable',
        'orders.*.no_batch' => 'required',
        'orders.*.no_exp' => 'required|date',
    ];

    public function setPurchase($id)
    {
        $this->purchase = Purchase::with('orderList')->find($id);
        $this->orders = $this->purchase->orderList;
    }

    public function confirm()
    {
        $this->validate();

        foreach ($this->orders as $order) {
            Stock::create([
                'obat_id' => $order->obat_id,
                'stok' => $order->kuantitas,
                'harga_jual' => $order->medicine->harga + ($order->medicine->harga * 0.1),
                'no_batch' => $order->no_batch,
                'no_exp' => $order->no_exp,
                'status' => 'Active'
            ]);

            unset($order->no_batch);
            unset($order->no_exp);

            $order->status = 'Complete';
            $order->save();
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
