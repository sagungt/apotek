<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class EditModal extends Component
{
    public $supplier;

    protected $listeners = ['setSupplier'];
    protected $rules = [
        'supplier.name'    => 'required',
        'supplier.npwp'    => 'required',
        'supplier.address' => 'required|max:255',
        'supplier.city'    => 'required',
        'supplier.phone'   => 'required',
        'supplier.fax'     => 'required',
        'supplier.email'   => 'required|email',
    ];
    protected $messages = [
        'supplier.name.required'    => 'The Supplier Name field is required',
        'supplier.npwp.required'    => 'The Supplier NPWP field is required',
        'supplier.address.required' => 'The Supplier Address field is required',
        'supplier.city.required'    => 'The Supplier City field is required',
        'supplier.phone.required'   => 'The Supplier Phone field is required',
        'supplier.fax.required'     => 'The Supplier FAX field is required',
        'supplier.email.required'   => 'The Supplier Email field is required',
    ];

    public function setSupplier($id)
    {
        $this->supplier = Supplier::find($id);
    }

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'name'    => $validated['supplier']['name'],
            'npwp'    => $validated['supplier']['email'],
            'address' => $validated['supplier']['address'],
            'city'    => $validated['supplier']['city'],
            'phone'   => $validated['supplier']['phone'],
            'fax'     => $validated['supplier']['fax'],
            'email'   => $validated['supplier']['email'],
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
