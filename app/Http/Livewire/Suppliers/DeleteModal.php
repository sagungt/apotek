<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class DeleteModal extends Component
{
    public $supplierId;

    protected $listeners = ['setSupplierId'];

    public function setSupplierId($id)
    {
        $this->supplierId = $id;
    }

    public function delete()
    {
        try {
            Supplier::destroy($this->supplierId);
        } catch (\Exception $e) {
            return session()->flash('error', 'Failed');
        }

        $this->dispatchBrowserEvent('close-modal-delete-supplier');
        $this->emitUp('reset');

        return session()->flash('success', 'Supplier deleted!');
    }

    public function render()
    {
        return view('livewire.suppliers.delete-modal');
    }
}
