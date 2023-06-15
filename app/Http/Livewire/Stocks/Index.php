<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Purchase;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['reset' => 'refresh'];

    public function refresh()
    {
        $this->resetPage();
    }

    public function render()
    {
        $purchases = Purchase::query()
            ->latest()
            ->paginate(10);

        return view('livewire.stocks.index', compact('purchases'));
    }
}
