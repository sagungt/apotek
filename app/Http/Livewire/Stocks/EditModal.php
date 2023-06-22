<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Illuminate\Support\Arr;
use Livewire\Component;

class EditModal extends Component
{
    public $stock;

    protected $listeners = ['setStock'];

    protected $rules = [
        'stock.medicine.nama_obat' => 'nullable',
        'stock.no_batch'           => 'required',
        'stock.no_exp'             => 'required',
        'stock.harga_jual'         => 'required',
        'stock.stok'               => 'required',
        'stock.status'             => 'required',
    ];

    public function setStock($id)
    {
        $this->stock = Stock::with('medicine')->find($id);
    }

    public function submit()
    {
        $validated = $this->validate();

        $this->stock->update([
            ...Arr::except($validated, ['mediecine']),
        ]);

        $this->emitUp('reset');

        return session()->flash('success', 'Stock updated!');
    }

    public function render()
    {
        return view('livewire.stocks.edit-modal');
    }
}
