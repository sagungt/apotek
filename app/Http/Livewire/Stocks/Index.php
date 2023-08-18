<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $currentMonth;
    public $isHistory;
    public $date;
    public $search;
    public $name;
    public $startDate;
    public $endDate;
    public $isFilter;
    public $printStartDate;
    public $printEndDate;
    public $printStartDate1;
    public $printEndDate1;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['reset' => 'refresh'];

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

    public function refresh()
    {
        $this->resetPage();
    }

    public function print()
    {
        $this->validate(['name' => 'required', 'printStartDate1' => 'nullable|date', 'printEndDate1' => 'nullable|date']);
        return redirect()->route('histories.printPurchases', ['date' => $this->currentMonth->format('Y-m-d'), 'name' => $this->name, 'startDate' => $this->printStartDate1 ?? null, 'endDate' => $this->printEndDate1 ?? null]);
    }

    public function generatePdf()
    {
        $this->validate(['name' => 'required', 'printStartDate' => 'nullable|date', 'printEndDate' => 'nullable|date']);
        $purchases = Purchase::query()
            ->whereIn('status', ['Complete'])
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
        $filename = Carbon::now()->format('Y-m') . '_PEMBELIAN.pdf';
        $pdf = Pdf::loadView('pdf.pembelian', ['pembelian' => $purchases, 'tanggal' => Carbon::now()->format('Y-m'), 'name' => $this->name, 'now' => Carbon::now()->format('Y-m-d')])->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $filename,
        );
    }

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
        $role = auth()->user()->role;
        $totalMonth = null;
        switch ($role) {
            case 1:
                $purchases = Purchase::query()
                    ->when($this->isHistory, fn ($query) =>
                        $query
                            ->whereIn('status', ['Complete'])
                    )
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
                            ->orWhere('tanggal', 'like', '%' . $this->search . '$')
                            ->orWhere('tanggal_terima', 'like', '%' . $this->search . '$')
                            ->orWhere('total', 'like', '%' . $this->search . '%')
                            ->orWhere('status', 'like', '%' . $this->search . '%')
                            ->orWhereHas('supplier', fn ($query) =>
                                $query
                                    ->where('supplier_nama', 'like', '%' . $this->search . '%')
                            )
                    )
                    ->when($this->isFilter, fn ($query) =>
                        $query
                            ->whereBetween('tanggal', array($this->startDate, $this->endDate))
                            ->orWhereBetween('tanggal_terima', array($this->startDate, $this->endDate))
                    )
                    ->latest();
                $totalMonth = array_sum($purchases->pluck('total')->toArray());
                $purchases = $purchases->paginate(10);
                break;

            case 2:
                $purchases = Purchase::query()
                    ->whereIn('status', ['Approved', 'Complete'])
                    ->when(strlen($this->search) > 0, fn ($query) =>
                        $query
                            ->where('no_faktur', 'like', '%' . $this->search . '%')
                            ->orWhere('tanggal', 'like', '%' . $this->search . '$')
                            ->orWhere('tanggal_terima', 'like', '%' . $this->search . '$')
                            ->orWhere('total', 'like', '%' . $this->search . '%')
                            ->orWhere('status', 'like', '%' . $this->search . '%')
                            ->orWhereHas('supplier', fn ($query) =>
                                $query
                                    ->where('supplier_nama', 'like', '%' . $this->search . '%')
                            )
                    )
                    ->when($this->isFilter, fn ($query) =>
                        $query
                            ->whereBetween('tanggal', array($this->startDate, $this->endDate))
                            ->orWhereBetween('tanggal_terima', array($this->startDate, $this->endDate))
                    )
                    ->latest()
                    ->paginate(10);
                break;

            default:
                $purchases = Purchase::query()
                    ->when(strlen($this->search) > 0, fn ($query) =>
                        $query
                            ->where('no_faktur', 'like', '%' . $this->search . '%')
                            ->orWhere('tanggal', 'like', '%' . $this->search . '$')
                            ->orWhere('tanggal_terima', 'like', '%' . $this->search . '$')
                            ->orWhere('total', 'like', '%' . $this->search . '%')
                            ->orWhere('status', 'like', '%' . $this->search . '%')
                            ->orWhereHas('supplier', fn ($query) =>
                                $query
                                    ->where('supplier_nama', 'like', '%' . $this->search . '%')
                            )
                    )
                    ->when($this->isFilter, fn ($query) =>
                        $query
                            ->whereBetween('tanggal', array($this->startDate, $this->endDate))
                            ->orWhereBetween('tanggal_terima', array($this->startDate, $this->endDate))
                    )
                    ->latest()
                    ->paginate(10);
                break;
        }

        return view('livewire.stocks.index', compact('purchases', 'totalMonth'));
    }
}
