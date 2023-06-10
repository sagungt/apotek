<?php

namespace App\Http\Livewire\Medicines;

use App\Models\Medicine;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['reset' => 'refresh'];

    public function refresh()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $medicines = Medicine::query()
            ->with(['category', 'brand'])
            ->when(strlen($this->search) > 0, fn ($query) =>
                $query
                    ->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('no_batch', 'like', '%' . $this->search . '%')
                    ->orWhere('no_exp', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('price', 'like', '%' . $this->search . '%')
                    ->orWhereHas('category', fn ($query) =>
                        $query->where('name', 'like', '%' . $this->search . '%')
                    )
                    ->orWhereHas('brand', fn ($query) =>
                        $query->where('name', 'like', '%' . $this->search . '%')
                    )
            )
            ->paginate(10);

        return view('livewire.medicines.index', compact('medicines'));
    }
}
