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
        'medicine.no_exp'      => 'required|date',
        'medicine.nama_obat'   => 'required',
        'medicine.satuan'      => 'required',
        'medicine.harga'       => 'required|numeric',
        'medicine.kategori_id' => 'required|exists:kategori,kategori_id',
        'medicine.merek_id'    => 'required|exists:merek,merek_id',
    ];
    protected $messages = [
        'medicine.no_batch.required'    => 'The No Batch field is required',
        'medicine.no_exp.required'      => 'The No Exp field is required',
        'medicine.no_exp.date'          => 'Invalid Date Format',
        'medicine.nama_obat.required'   => 'The Medicine Name field is required',
        'medicine.satuan.required'      => 'The Medicine Unit of Measurement field is required',
        'medicine.harga.required'       => 'The Medicine Price field is required',
        'medicine.kategori_id.required' => 'The Medicine Category field is required',
        'medicine.merek_id.required'    => 'The Medicine Brand field is required',
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

        $this->medicine->update([...$validated['medicine']]);

        $this->emitUp('reset');

        return session()->flash('success', 'Medicine successfully updated!');
    }

    public function render()
    {
        return view('livewire.medicines.edit-modal');
    }
}
