<?php

namespace App\Http\Livewire\Stocks;

use App\Models\OrderList;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Sell as SellModel;
use App\Models\Stock;
use Illuminate\Support\Carbon;

class Sell extends Component
{
    public $search;
    public $sell;
    public $medicines;
    public $orderList = [];
    public $grandTotal = 0;
    public $order;
    public $quantities = [];

    protected $rules = [
        'sell.tanggal'        => 'required|date',
        'sell.tipe'           => 'required|in:Resep,Non Resep',
        'sell.nama_dokter'    => 'required_if:sell.tipe,Resep',
        'sell.nama_pelanggan' => 'required_if:sell.tipe,Resep',
        // 'sell.no_faktur'      => 'required',
    ];

    public function mount()
    {
        // $this->sell['no_faktur'] = Str::upper(Str::random(10));
        $this->sell['tanggal'] = Carbon::now()->format('Y-m-d');
    }

    public function submit()
    {
        // dd($this->sell);
        $this->validate();

        if (sizeof($this->orderList) === 0) {
            return session()->flash('error', 'Pilih obat minimal 1');
        }

        $penjualan = SellModel::create([
            ...$this->sell,
            'jumlah' => $this->grandTotal,
        ]);

        $penjualan->no_faktur = 'OB' . Carbon::now()->format('dmY') . '-' . $penjualan->penjualan_id;
        $penjualan->save();

        foreach ($this->orderList as $order) {
            $stock = Stock::find($order['obat_id']);
            $flow = SellModel::find($penjualan->penjualan_id);
            $orderList = new OrderList();
            $orderList->flow()->associate($flow);
            $orderList->medicine()->associate($stock);
            $orderList->kuantitas = $order['kuantitas'];
            $orderList->total = $order['total'];
            $orderList->status = 'Sold';
            $orderList->save();

            $stock->stok -= $order['kuantitas'];
            $stock->save();
        }

        $this->orderList = [];

        $this->reset();

        return redirect()->route('sales.index')->with(['success' => 'Penjualan berhasil']);
    }

    public function addToList()
    {
        $this->validate([
            'order.obat_id'   => 'required|exists:persediaan_obat,id',
            'order.kuantitas' => 'required|numeric|min:1',
        ]);

        $stock = Stock::find($this->order['obat_id']);
        $errorHandling = function() {
            $this->setErrorBag([
                'order.kuantitas' => 'Stok kurang',
            ]);
        };
        $error = $this->checkStock($stock, $this->order['kuantitas'], $errorHandling);
        if ($error) return;

        $this->add($stock, $this->order['obat_id'], $this->order['kuantitas'], $errorHandling);
    }

    public function add($stock, $id, $qty, ?callable $callback = null)
    {
        $price = ($stock->medicine->harga + ($stock->medicine->harga * 0.1)) * $qty;
        $inList = array_filter($this->orderList, fn ($order) => $order['obat_id'] == $id);
        if (empty($inList)) {
            array_push($this->orderList, [
                'obat_id'   => $stock->id,
                'nama'      => $stock->medicine->nama_obat,
                'no_batch'  => $stock->no_batch,
                'kuantitas' => $qty,
                'total'     => $price,
            ]);
        } else {
            $index = array_search($id, collect($this->orderList)->pluck('obat_id')->toArray());
            
            $error = $this->checkStock($stock, $this->orderList[$index]['kuantitas'] + $qty, $callback);
            if ($error) return;

            $this->orderList[$index]['kuantitas'] += $qty;
            $this->orderList[$index]['total'] += $price;
        }

        $this->grandTotal = array_sum(collect($this->orderList)->pluck('total')->toArray());
    }

    public function addOne($id, $index)
    {
        $this->validate([
            "quantities.$index" => 'required|min:1',
        ]);
        $stock = Stock::find($id);
        $errorHandling = function() {
            return session()->flash('error', 'Stok kurang');
        };
        $error = $this->checkStock($stock, $this->quantities[$index], $errorHandling);

        if ($error) return;

        $this->add($stock, $id, $this->quantities[$index], $errorHandling);
    }

    private function checkStock($stock, $addition, ?callable $callback = null)
    {
        if (intval($addition) > $stock->stok) {
            $callback();
            return true;
        }
        return false;
    }

    public function updated($propName, $val)
    {
        $this->resetErrorBag();
    }

    public function render()
    {
        $stocks = Stock::with(['medicine', 'medicine.category', 'medicine.brand'])
            ->where('status', 'Active')
            ->when(strlen($this->search) > 0, fn ($query) =>
                $query
                    ->whereHas('medicine', fn ($query) =>
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
                    ->orWhere('no_batch', 'like', '%' . $this->search . '%')
            )
            ->get();

        return view('livewire.stocks.sell', compact('stocks'));
    }
}
