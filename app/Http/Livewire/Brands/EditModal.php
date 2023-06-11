<?php

namespace App\Http\Livewire\Brands;

use App\Models\Brand;
use Livewire\Component;

class EditModal extends Component
{
    public $brand;

    protected $listeners = ['setBrand'];

    protected $rules = [
        'brand.nama_merek'             => 'required|unique:merek,nama_merek',
    ];
    protected $messages = [
        'brand.name_merek.required'    => 'The Brand Name field is required',
    ];

    public function setBrand($id)
    {
        $this->brand = Brand::find($id);
    }

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'nama_merek'  => $validated['brand']['nama_merek'],
        ];

        $this->brand->update($data);

        $this->emitUp('reset');

        return session()->flash('success', 'Brands successfully updated!');
    }

    public function render()
    {
        return view('livewire.brands.edit-modal');
    }
}
