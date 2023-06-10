<?php

namespace App\Http\Livewire\Medicines;

use App\Models\Medicine;
use Livewire\Component;

class DeleteModal extends Component
{
    public $medicineId;

    protected $listeners = ['setMedicineId'];

    public function setMedicineId($id)
    {
        $this->medicineId = $id;
    }

    public function delete()
    {
        try {
            Medicine::destroy($this->medicineId);
        } catch (\Exception $e) {
            return session()->flash('error', 'Failed');
        }

        $this->dispatchBrowserEvent('close-modal-delete-medicine');
        $this->emitUp('reset');

        return session()->flash('success', 'Medicine deleted!');
    }

    public function render()
    {
        return view('livewire.medicines.delete-modal');
    }
}
