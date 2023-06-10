<?php

namespace App\Http\Livewire\Brands;

use App\Models\Brand;
use Livewire\Component;

class DeleteModal extends Component
{
    public $brandId;

    protected $listeners = ['setBrandId'];

    public function setBrandId($id)
    {
        $this->brandId = $id;
    }

    public function delete()
    {
        try {
            Brand::destroy($this->brandId);
        } catch (\Exception $e) {
            return session()->flash('error', 'Failed');
        }

        $this->dispatchBrowserEvent('close-modal-delete-brand');
        $this->emitUp('reset');

        return session()->flash('success', 'Brand deleted!');
    }

    public function render()
    {
        return view('livewire.brands.delete-modal');
    }
}
