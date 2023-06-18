<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Expiry extends Component
{
    use WithPagination;

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
                    ->with(['medicine', 'medicine.category', 'medicine.brand'])
                    ->where(function ($query) {
                        $threeMonthFromNow = Carbon::now()->addMonths(3);
                        return $query
                            ->whereDate('no_exp', '<=', $threeMonthFromNow);
                    })
                    ->latest()
                    ->paginate(10);
                break;
            
            default:
                $expires = Stock::query()
                    ->where('status', 'Almost Expired')
                    ->with(['medicine', 'medicine.category', 'medicine.brand'])
                    ->latest()
                    ->paginate(10);
                break;
        }

        return view('livewire.stocks.expiry', compact('expires'));
    }
}
