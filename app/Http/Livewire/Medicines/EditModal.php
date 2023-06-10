<?php

namespace App\Http\Livewire\Medicines;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Medicine;
use Livewire\Component;

class EditModal extends Component
{
    public $medicine;
    public $categories;
    public $brands;

    protected $listeners = ['setMedicine'];
    protected $rules = [
        'medicine.no_batch'    => 'required',
        'medicine.no_exp'      => 'required',
        'medicine.name'        => 'required',
        'medicine.uom'         => 'required',
        'medicine.category_id' => 'required|exists:categories,id',
        'medicine.brand_id'    => 'required|exists:brands,id',
    ];
    protected $messages = [
        'medicine.no_batch.required'    => 'The No Batch field is required',
        'medicine.no_exp.required'      => 'The No Exp field is required',
        'medicine.name.required'        => 'The Medicine Name field is required',
        'medicine.uom.required'         => 'The Medicine Unit of Measurement field is required',
        'medicine.category_id.required' => 'The Medicine Category field is required',
        'medicine.brand_id.required'    => 'The Medicine Brand field is required',
    ];

    public function mount ()
    {
        $this->categories = Category::all();
        $this->brands     = Brand::all();
    }

    public function setMedicine($id)
    {
        $this->medicine = Medicine::find($id);
    }

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'no_batch'    => $validated['medicine']['no_batch'],
            'no_exp'      => $validated['medicine']['no_exp'],
            'name'        => $validated['medicine']['name'],
            'uom'         => $validated['medicine']['uom'],
            'category_id' => $validated['medicine']['category_id'],
            'brand_id'    => $validated['medicine']['brand_id'],
        ];

        $this->medicine->update($data);

        $this->emitUp('reset');

        return session()->flash('success', 'Medicine successfully updated!');
    }

    public function render()
    {
        return view('livewire.medicines.edit-modal');
    }
}
