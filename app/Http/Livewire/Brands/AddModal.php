<?php

namespace App\Http\Livewire\Brands;

use App\Models\Brand;
use Livewire\Component;

class AddModal extends Component
{
    public $newBrand;

    protected $rules = [
        'newBrand.nama_merek'          => 'required|unique:merek,nama_merek',
    ];
    protected $messages = [
        'newBrand.nama_merek.required' => 'The Brand Name field is required',
    ];

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'nama_merek'  => $validated['newBrand']['nama_merek'],
        ];
        
        Brand::create($data);

        $this->dispatchBrowserEvent('close-modal-add-brand');
        $this->emitUp('reset');
        $this->reset(['newBrand']);

        return session()->flash('success', 'Brand successfully created!');
    }

    public function render()
    {
        return view('livewire.brands.add-modal');
    }
}
