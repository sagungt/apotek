<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Purchase;
use Livewire\Component;

class DetailModal extends Component
{
    public $purchase;

    protected $listeners = ['setPurchase'];

    public function setPurchase($id)
    {
        $this->purchase = Purchase::find($id);
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

    public function render()
    {
        return view('livewire.stocks.detail-modal');
    }
}
