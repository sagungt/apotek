<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\Supplier;
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
        $suppliers = Supplier::query()
            ->when(strlen($this->search) > 0, fn ($query) =>
                $query
                    ->where('supplier_id', 'like', '%' . $this->search . '%')
                    ->orWhere('supplier_nama', 'like', '%' . $this->search . '%')
                    ->orWhere('npwp', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat', 'like', '%' . $this->search . '%')
                    ->orWhere('kota', 'like', '%' . $this->search . '%')
                    ->orWhere('telepon', 'like', '%' . $this->search . '%')
                    ->orWhere('fax', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
            )
            ->paginate(10);

        return view('livewire.suppliers.index', compact('suppliers'));
    }
}
