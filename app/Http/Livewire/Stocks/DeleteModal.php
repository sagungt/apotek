<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Livewire\Component;

class DeleteModal extends Component
{
    public $stockId;

    protected $listeners = ['setStockId'];

    public function setStockId($id)
    {
        $this->stockId = $id;
    }

    public function delete()
    {
        try {
            Stock::destroy($this->stockId);
        } catch (\Exception $e) {
            return session()->flash('error', 'Failed');
        }

        $this->dispatchBrowserEvent('close-modal-delete-modal');
        $this->emitUp('reset');

        return session()->flash('success', 'Stock deleted!');
    }

    public function render()
    {
        return view('livewire.stocks.delete-modal');
    }
}
