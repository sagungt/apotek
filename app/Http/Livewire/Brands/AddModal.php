<?php

namespace App\Http\Livewire\Brands;

use App\Models\Brand;
use Livewire\Component;

class AddModal extends Component
{
    public $newBrand;

    protected $rules = [
        'newBrand.name'          => 'required|unique:brands,name',
    ];
    protected $messages = [
        'newBrand.name.required' => 'The Brand Name field is required',
    ];

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'name'  => $validated['newBrand']['name'],
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
