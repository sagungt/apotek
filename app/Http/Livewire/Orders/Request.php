<?php

namespace App\Http\Livewire\Orders;

use App\Models\Medicine;
use Livewire\Component;

class Request extends Component
{
    public $medicines;

    public function mount()
    {
        $this->medicines = Medicine::all();
    }

    public function render()
    {
        return view('livewire.orders.request');
    }
}
