<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock as ModelsStock;
use Livewire\Component;
use Livewire\WithPagination;

class Stock extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['reset' => 'refresh'];

    public function refresh()
    {
        $this->resetPage();
    }

    public function render()
    {
        $stocks = ModelsStock::query()
            ->with('medicine')
            ->when(strlen($this->search) > 0, fn ($query) =>
                $query
                    ->where('no_batch', 'like', '%' . $this->search . '%')
                    ->orWhere('no_exp', 'like', '%' . $this->search . '%')
                    ->orWhere('harga_jual', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('suppliers', 'like', '%' . $this->search . '%')
                    ->orWhere('stok', 'like', '%' . $this->search . '%')
                    ->orWhereHas('medicine' , fn ($query) =>
                        $query
                            ->where('nama_obat', 'like', '%' . $this->search . '%')
                    )
            )
            ->latest()
            ->paginate(10);

        return view('livewire.stocks.stock', compact('stocks'));
    }
}
