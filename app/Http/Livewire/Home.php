<?php

namespace App\Http\Livewire;

use App\Models\OrderList;
use App\Models\Purchase;
use App\Models\Sell;
use App\Models\Stock;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Home extends Component
{
    public $purchaseCount;
    public $purchasesDetail;
    public $saleCount;
    public $salesDetail;
    public $stockCount;
    public $stockDetail;
    public $almostExpiredCount;

    public function mount()
    {
        $this->purchaseCount = Purchase::whereIn('status', ['Purchasing', 'Complete'])->count();
        $this->purchasesDetail = Purchase::whereIn('status', ['Purchasing', 'Complete'])
                ->sum('total');
        $this->saleCount = Sell::count();
        $this->salesDetail = Sell::sum('jumlah');
        $this->stockCount = Stock::sum('stok');
        $this->stockDetail = OrderList::where('status', 'Sold')->sum('kuantitas');
        $role = auth()->user()->role;
        switch ($role) {
            case 3:
                $this->almostExpiredCount = Stock::query()
                    ->where('status', 'Almost Expired')
                    ->count();
                break;
                
            default:
                $threeMonthFromNow = Carbon::now()->addMonths(3);
                $this->almostExpiredCount = DB::table('persediaan_obat')
                    ->whereDate('no_exp', '>=', Carbon::now())
                    ->whereDate('no_exp', '<=', $threeMonthFromNow)
                    ->count();
                break;
        }
    }

    public function render()
    {
        return view('livewire.home');
    }
}
