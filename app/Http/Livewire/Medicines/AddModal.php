<?php

namespace App\Http\Livewire\Medicines;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Medicine;
use Livewire\Component;

class AddModal extends Component
{
    public $newMedicine;
    public $categories;
    public $brands;

    protected $rules = [
        'newMedicine.no_batch'    => 'required',
        'newMedicine.no_exp'      => 'required',
        'newMedicine.name'        => 'required',
        'newMedicine.uom'         => 'required',
        'newMedicine.category_id' => 'required|exists:categories,id',
        'newMedicine.brand_id'    => 'required|exists:brands,id',
    ];
    protected $messages = [
        'newMedicine.no_batch.required'    => 'The No Batch field is required',
        'newMedicine.no_exp.required'      => 'The No Exp field is required',
        'newMedicine.name.required'        => 'The Medicine Name field is required',
        'newMedicine.uom.required'         => 'The Medicine Unit of Measurement field is required',
        'newMedicine.category_id.required' => 'The Medicine Category field is required',
        'newMedicine.brand_id.required'    => 'The Medicine Brand field is required',
    ];

    public function mount()
    {
        $this->categories = Category::all();
        $this->brands     = Brand::all();
    }

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'no_batch'    => $validated['newMedicine']['no_batch'],
            'no_exp'      => $validated['newMedicine']['no_exp'],
            'name'        => $validated['newMedicine']['name'],
            'uom'         => $validated['newMedicine']['uom'],
            'category_id' => $validated['newMedicine']['category_id'],
            'brand_id'    => $validated['newMedicine']['brand_id'],
        ];
        
        Medicine::create($data);

        $this->dispatchBrowserEvent('close-modal-add-medicine');
        $this->emitUp('reset');
        $this->reset(['newMedicine']);

        return session()->flash('success', 'Medicine successfully created!');
    }

    public function render()
    {
        return view('livewire.medicines.add-modal');
    }
}
