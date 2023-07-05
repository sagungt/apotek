<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Sell;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Sales extends Component
{
    use WithPagination;

    public $isHistory;
    public $currentMonth;
    public $search = '';
    public $name;

    public function mount($isHistory = true)
    {
        $this->isHistory = $isHistory;
        $this->currentMonth = Carbon::now();
    }

    public function updatingDate($val)
    {
        try {
            $this->resetErrorBag(['date']);
            $this->currentMonth = Carbon::parse($val);
        } catch (\Exception $e) {
            $this->setErrorBag([
                'date' => 'Invalid Format'
            ]);
        }
    }

    public function addMonth()
    {
        $this->currentMonth->addMonth();
    }

    public function subMonth()
    {
        $this->currentMonth->subMonth();
    }

    public function resetDate()
    {
        $this->currentMonth = Carbon::now();
        $this->reset('date');
    }

    public function print()
    {
        $this->validate(['name' => 'required']);
        return redirect()->route('histories.printSales', ['date' => $this->currentMonth->format('Y-m-d'), 'name' => $this->name]);
    }

    public function generatePdf()
    {
        $this->validate(['name' => 'required']);
        $sales = Sell::query()
            ->where(function ($query) {
                $first = Carbon::parse($this->currentMonth)->startOfMonth();
                $last = Carbon::parse($this->currentMonth)->endOfMonth();
                return $query
                    ->whereDate('tanggal', '>=', $first)
                    ->whereDate('tanggal', '<=', $last);
            })
            ->get();
        $filename = Carbon::now()->format('Y-m') . '_PENJUALAN.pdf';
        $pdf = Pdf::loadView('pdf.penjualan', ['penjualan' => $sales, 'tanggal' => Carbon::now()->format('Y-m'), 'name' => $this->name, 'now' => Carbon::now()->format('Y-m-d')])->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $filename,
        );
    }

    public function render()
    {
        $role = auth()->user()->role;
        $totalMonth = null;
        switch ($role) {
            case 1:
                $sales = Sell::query()
                    ->when($this->isHistory, fn ($query) =>
                        $query
                            ->where(function ($query) {
                                $first = Carbon::parse($this->currentMonth)->startOfMonth();
                                $last = Carbon::parse($this->currentMonth)->endOfMonth();
                                return $query
                                    ->whereDate('tanggal', '>=', $first)
                                    ->whereDate('tanggal', '<=', $last);
                            })
                    )
                    ->when(strlen($this->search) > 0, fn ($query) =>
                        $query
                            ->where('no_faktur', 'like', '%' . $this->search . '%')
                            ->orWhere('tanggal', 'like', '%' . $this->search . '%')
                            ->orWhere('jumlah', 'like', '%' . $this->search . '%')
                            ->orWhere('tipe', 'like', '%' . $this->search . '%')
                            ->orWhere('nama_dokter', 'like', '%' . $this->search . '%')
                            ->orWhere('nama_pelanggan', 'like', '%' . $this->search . '%')
                    )
                    ->latest();
                $totalMonth = array_sum($sales->pluck('jumlah')->toArray());
                $sales = $sales->paginate(10);
                break;

            default:
                $sales = Sell::query()
                    ->when(strlen($this->search) > 0, fn ($query) =>
                        $query
                            ->where('no_faktur', 'like', '%' . $this->search . '%')
                            ->orWhere('tanggal', 'like', '%' . $this->search . '%')
                            ->orWhere('jumlah', 'like', '%' . $this->search . '%')
                            ->orWhere('tipe', 'like', '%' . $this->search . '%')
                            ->orWhere('nama_dokter', 'like', '%' . $this->search . '%')
                            ->orWhere('nama_pelanggan', 'like', '%' . $this->search . '%')
                    )
                    ->latest()
                    ->paginate(10);
                break;
        }

        return view('livewire.stocks.sales', compact('sales', 'totalMonth'));
    }
}
