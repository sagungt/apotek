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
        'newMedicine.harga'       => 'required|numeric',
        'newMedicine.jenis'       => 'required',
        'newMedicine.kategori_id' => 'required|exists:kategori,kategori_id',
        // 'newMedicine.merek_id'    => 'required|exists:merek,merek_id',
    ];
    protected $messages = [
        'newMedicine.nama_obat.required'   => 'The Medicine Name field is required',
        'newMedicine.satuan.required'      => 'The Medicine Unit of Measurement field is required',
        'newMedicine.minimal_stok.required'      => 'Minimal_stokt field is required',
        'newMedicine.harga.required'       => 'The Medicine Price field is required',
        'newMedicine.jenis.required'       => 'The Medicine Type field is required',
        'newMedicine.kategori_id.required' => 'The Medicine Category field is required',
        // 'newMedicine.merek_id.required'    => 'The Medicine Brand field is required',
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
