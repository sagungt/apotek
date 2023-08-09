<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Expiry extends Component
{
    use WithPagination;

    public $search;

    public function markAlmostExpired($id)
    {
        $stock = Stock::find($id);

        $stock->status = 'Almost Expired';
        $stock->save();
    }

    public function markExpired($id)
    {
        $stock = Stock::find($id);

        $stock->status = 'Expired';
        $stock->save();
    }

    public function render()
    {
        $role = auth()->user()->role;
        switch ($role) {
            case 2:
                $expires = Stock::query()
                    // ->with(['medicine', 'medicine.category', 'medicine.brand'])
                    ->with(['medicine', 'medicine.category'])
                    ->where(function ($query) {
                        $threeMonthFromNow = Carbon::now()->addMonths(3);
                        return $query
                            ->whereDate('no_exp', '<=', $threeMonthFromNow);
                    })
                    ->when(strlen($this->search) > 0, fn ($query) =>
                        $query
                            ->where(fn ($query) =>
                                $query
                                    ->where('no_batch', 'like', '%' . $this->search . '%')
                                    ->orWhere('no_exp', 'like', '%' . $this->search . '%')
                                    ->orWhere('harga_jual', 'like', '%' . $this->search . '%')
                                    ->orWhere('status', 'like', '%' . $this->search . '%')
                                    ->orWhere('stok', 'like', '%' . $this->search . '%')
                                    ->orWhereHas('medicine' , fn ($query) =>
                                        $query
                                            ->where('nama_obat', 'like', '%' . $this->search . '%')
                                    )
                            )
                    )
                    ->latest()
                    ->paginate(10);
                break;
            
            default:
                $expires = Stock::query()
                    ->where('status', 'Almost Expired')
                    // ->with(['medicine', 'medicine.category', 'medicine.brand'])
                    ->with(['medicine', 'medicine.category'])
                    ->when(strlen($this->search) > 0, fn ($query) =>
                        $query
                            ->where(fn ($query) =>
                                $query
                                    ->where('no_batch', 'like', '%' . $this->search . '%')
                                    ->orWhere('no_exp', 'like', '%' . $this->search . '%')
                                    ->orWhere('harga_jual', 'like', '%' . $this->search . '%')
                                    ->orWhere('status', 'like', '%' . $this->search . '%')
                                    ->orWhere('stok', 'like', '%' . $this->search . '%')
                                    ->orWhereHas('medicine' , fn ($query) =>
                                        $query
                                            ->where('nama_obat', 'like', '%' . $this->search . '%')
                                    )
                            )
                    )
                    ->latest()
                    ->paginate(10);
                break;
        }

        return view('livewire.stocks.expiry', compact('expires'));
    }
}
