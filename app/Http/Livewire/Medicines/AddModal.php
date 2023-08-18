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
        'newMedicine.nama_obat'   => 'required',
        'newMedicine.satuan'      => 'required',
        'newMedicine.minimal_stok'      => 'required',
        'newMedicine.suppliers'       => 'required',
        'newMedicine.jenis'       => 'required',
        'newMedicine.kategori_id' => 'required|exists:kategori,kategori_id',
        'newMedicine.harga_per_box' => 'required|numeric',
        'newMedicine.isi_box' => 'required|numeric',
        'newMedicine.margin'    => 'required|numeric|min:0|max:100',
    ];
    protected $messages = [
        'newMedicine.nama_obat.required'   => 'The Medicine Name field is required',
        'newMedicine.satuan.required'      => 'The Medicine Unit of Measurement field is required',
        'newMedicine.minimal_stok.required'      => 'Minimal_stokt field is required',
        'newMedicine.suppliers.required'       => 'The Medicine Price field is required',
        'newMedicine.jenis.required'       => 'The Medicine Type field is required',
        'newMedicine.kategori_id.required' => 'The Medicine Category field is required',
        'newMedicine.harga_per_box.required' => 'The Medicine Price field is required',
        'newMedicine.isi_box.required' => 'The Medicine Count field is required',
        'newMedicine.margin.required'    => 'The Medicine Margin field is required',
    ];

    public function mount()
    {
        $this->categories = Category::all();
        $this->brands     = Brand::all();
    }

    public function submit()
    {
        $validated = $this->validate();

        Medicine::create([...$validated['newMedicine']]);

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
