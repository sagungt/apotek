<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class AddModal extends Component
{
    public $newSupplier;

    protected $rules = [
        'newSupplier.supplier_nama' => 'required',
        'newSupplier.npwp'          => 'required',
        'newSupplier.alamat'        => 'required|max:255',
        'newSupplier.kota'          => 'required',
        'newSupplier.telepon'       => 'required',
        'newSupplier.fax'           => 'required',
        'newSupplier.email'         => 'required|email',
    ];
    protected $messages = [
        'newSupplier.supplier_nama.required' => 'The Supplier Name field is required',
        'newSupplier.npwp.required'          => 'The Supplier NPWP field is required',
        'newSupplier.alamat.required'        => 'The Supplier Address field is required',
        'newSupplier.kota.required'          => 'The Supplier City field is required',
        'newSupplier.telepon.required'       => 'The Supplier Phone field is required',
        'newSupplier.fax.required'           => 'The Supplier FAX field is required',
        'newSupplier.email.required'         => 'The Supplier Email field is required',
    ];

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'supplier_nama' => $validated['newSupplier']['supplier_nama'],
            'npwp'          => $validated['newSupplier']['email'],
            'alamat'        => $validated['newSupplier']['alamat'],
            'kota'          => $validated['newSupplier']['kota'],
            'telepon'       => $validated['newSupplier']['telepon'],
            'fax'           => $validated['newSupplier']['fax'],
            'email'         => $validated['newSupplier']['email'],
        ];
        
        Supplier::create($data);

        $this->dispatchBrowserEvent('close-modal-add-supplier');
        $this->emitUp('reset');
        $this->reset(['newSupplier']);

        return session()->flash('success', 'Supplier successfully created!');
    }

    public function render()
    {
        return view('livewire.suppliers.add-modal');
    }
}
