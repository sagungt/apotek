<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class EditModal extends Component
{
    public $supplier;

    protected $listeners = ['setSupplier'];
    protected $rules = [
        'supplier.supplier_nama' => 'required',
        'supplier.npwp'          => 'required',
        'supplier.alamat'        => 'required|max:255',
        'supplier.kota'          => 'required',
        'supplier.telepon'       => 'required',
        'supplier.fax'           => 'required',
        'supplier.email'         => 'required|email',
    ];
    protected $messages = [
        'supplier.supplier_nama.required' => 'The Supplier Name field is required',
        'supplier.npwp.required'          => 'The Supplier NPWP field is required',
        'supplier.alamat.required'        => 'The Supplier Address field is required',
        'supplier.kota.required'          => 'The Supplier City field is required',
        'supplier.telepon.required'       => 'The Supplier Phone field is required',
        'supplier.fax.required'           => 'The Supplier FAX field is required',
        'supplier.email.required'         => 'The Supplier Email field is required',
    ];

    public function setSupplier($id)
    {
        $this->supplier = Supplier::find($id);
    }

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'supplier_nama' => $validated['supplier']['supplier_nama'],
            'npwp'          => $validated['supplier']['npwp'],
            'alamat'        => $validated['supplier']['alamat'],
            'kota'          => $validated['supplier']['kota'],
            'telepon'       => $validated['supplier']['telepon'],
            'fax'           => $validated['supplier']['fax'],
            'email'         => $validated['supplier']['email'],
        ];

        $this->supplier->update($data);

        $this->emitUp('reset');

        return session()->flash('success', 'Supplier successfully updated!');
    }

    public function render()
    {
        return view('livewire.suppliers.edit-modal');
    }
}
