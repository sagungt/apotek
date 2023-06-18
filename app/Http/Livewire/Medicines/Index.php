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
                    ->where('obat_id', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_obat', 'like', '%' . $this->search . '%')
                    ->orWhere('harga', 'like', '%' . $this->search . '%')
                    ->orWhere('satuan', 'like', '%' . $this->search . '%')
                    ->orWhere('jenis', 'like', '%' . $this->search . '%')
                    ->orWhereHas('category', fn ($query) =>
                        $query->where('nama_kategori', 'like', '%' . $this->search . '%')
                    )
                    ->orWhereHas('brand', fn ($query) =>
                        $query->where('nama_merek', 'like', '%' . $this->search . '%')
                    )
            )
            ->paginate(10);

        return view('livewire.medicines.index', compact('medicines'));
    }
}
