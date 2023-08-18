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
    public $date;
    public $startDate;
    public $endDate;
    public $printStartDate;
    public $printEndDate;
    public $printStartDate1;
    public $printEndDate1;
    public $isFilter = false;

    protected $paginationTheme = 'bootstrap';

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
        $this->validate(['name' => 'required', 'printStartDate1' => 'nullable|date', 'printEndDate1' => 'nullable|date']);
        return redirect()->route('histories.printSales', ['date' => $this->currentMonth->format('Y-m-d'), 'name' => $this->name, 'startDate' => $this->printStartDate1 ?? null, 'endDate' => $this->printEndDate1 ?? null]);
    }

    public function filterDate()
    {
        $this->isFilter = true;
    }

    public function resetFilterDate()
    {
        $this->isFilter = false;
    }

    public function generatePdf()
    {
        $this->validate(['name' => 'required', 'printStartDate' => 'nullable|date', 'printEndDate' => 'nullable|date']);
        $sales = Sell::query()
            ->when(!$this->printStartDate && !$this->printEndDate, fn ($query) =>
                $query
                    ->where(function ($query) {
                        $first = Carbon::parse($this->currentMonth)->startOfMonth();
                        $last = Carbon::parse($this->currentMonth)->endOfMonth();
                        return $query
                            ->whereDate('tanggal', '>=', $first)
                            ->whereDate('tanggal', '<=', $last);
                    })
            )
            ->when($this->printStartDate, fn ($query) =>
                    $query
                        ->whereDate('tanggal', '>=', Carbon::parse($this->printStartDate))
            )
            ->when($this->printEndDate, fn ($query) =>
                    $query
                        ->whereDate('tanggal', '<=', Carbon::parse($this->printEndDate))
            )
            ->get();
        $filename = Carbon::now()->format('Y-m') . '_PENJUALAN.pdf';
        $pdf = Pdf::loadView('pdf.penjualan', ['penjualan' => $sales, 'tanggal' => Carbon::now()->format('Y-m'), 'name' => $this->name, 'now' => Carbon::now()->format('Y-m-d')])->setPaper('a4', 'landscape')->output();
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
                    ->with('orderList', 'orderList.medicine', 'orderList.medicine.medicine')
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
                    ->when($this->isFilter, fn ($query) =>
                        $query
                            ->whereBetween('tanggal', array($this->startDate, $this->endDate))
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
                    ->when($this->isFilter, fn ($query) =>
                        $query
                            ->whereBetween('tanggal', array($this->startDate, $this->endDate))
                    )
                    ->latest()
                    ->paginate(10);
                break;
        }

        return view('livewire.stocks.sales', compact('sales', 'totalMonth'));
    }
}
