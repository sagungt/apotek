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
        'medicine.nama_obat'   => 'required',
        'medicine.satuan'      => 'required',
        'medicine.minimal_stok'      => 'required',
        'medicine.suppliers'       => 'required',
        'medicine.jenis'       => 'required',
        'medicine.isi_box'       => 'required',
        'medicine.harga_per_box'       => 'required',
        'medicine.kategori_id' => 'required|exists:kategori,kategori_id',
        'medicine.margin'    => 'required|numeric|min:0|max:100',
    ];
    protected $messages = [
        'medicine.nama_obat.required'   => 'The Medicine Name field is required',
        'medicine.satuan.required'      => 'The Medicine Unit of Measurement field is required',
        'medicine.minimal_stok.required'      => 'Minimal Stok field is required',
        'medicine.suppliers.required'       => 'The Medicine Price field is required',
        'medicine.jenis.required'       => 'The Medicine Type field is required',
        'medicine.isi_box.required'       => 'The Medicine count field is required',
        'medicine.harga_per_box.required'       => 'The Medicine Price field is required',
        'medicine.kategori_id.required' => 'The Medicine Category field is required',
        'medicine.margin.required'    => 'The Medicine Margin field is required',
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
