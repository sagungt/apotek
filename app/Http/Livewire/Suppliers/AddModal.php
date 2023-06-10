<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class AddModal extends Component
{
    public $newSupplier;

    protected $rules = [
        'newSupplier.name'    => 'required',
        'newSupplier.npwp'    => 'required',
        'newSupplier.address' => 'required|max:255',
        'newSupplier.city'    => 'required',
        'newSupplier.phone'   => 'required',
        'newSupplier.fax'     => 'required',
        'newSupplier.email'   => 'required|email',
    ];
    protected $messages = [
        'newSupplier.name.required'    => 'The Supplier Name field is required',
        'newSupplier.npwp.required'    => 'The Supplier NPWP field is required',
        'newSupplier.address.required' => 'The Supplier Address field is required',
        'newSupplier.city.required'    => 'The Supplier City field is required',
        'newSupplier.phone.required'   => 'The Supplier Phone field is required',
        'newSupplier.fax.required'     => 'The Supplier FAX field is required',
        'newSupplier.email.required'   => 'The Supplier Email field is required',
    ];

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'name'    => $validated['newSupplier']['name'],
            'npwp'    => $validated['newSupplier']['email'],
            'address' => $validated['newSupplier']['address'],
            'city'    => $validated['newSupplier']['city'],
            'phone'   => $validated['newSupplier']['phone'],
            'fax'     => $validated['newSupplier']['fax'],
            'email'   => $validated['newSupplier']['email'],
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
