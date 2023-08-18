<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Medicine;
use Livewire\Component;
use Livewire\WithPagination;

class History extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $isFilter;

    public function filterDate()
    {
        $this->isFilter = true;
    }

    public function resetFilterDate()
    {
        $this->isFilter = false;
    }

    public function render()
    {
        $medicines = $this->isFilter ? Medicine::query()
            ->get() : [];

        return view('livewire.stocks.history', compact('medicines'));
    }
}
