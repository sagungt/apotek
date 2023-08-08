<?php

namespace App\Http\Livewire\Orders;

use App\Models\Medicine;
use App\Models\OrderList;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Request extends Component
{
    public $medicines;
    public $suppliers;
    public $orders = [];
    public $orderList;
    public $grandTotal = 0;
    public $pembelian;
    public $filterSuppliers;
    public $filterSupplier = 'all';
    public $info;

    protected $orderRules = [
        'orderList.obat_id' => 'required|exists:obat,obat_id',
        'orderList.kuantitas' => 'required|min:1|numeric',
    ];
    protected $purchaseRules = [
        'pembelian.tanggal' => 'required|date',
        // 'pembelian.supplier_id' => 'required|exists:supplier,supplier_id',
        'pembelian.keterangan' => 'nullable',
    ];

    public function mount()
    {
        $this->medicines = Medicine::all();
        $this->suppliers = Supplier::all();
        $this->filterSuppliers = Medicine::all()->unique('suppliers')->pluck('suppliers');
        $this->pembelian['tanggal'] = Carbon::now()->format('Y-m-d');
    }
    
    public function addToOrder()
    {
        $validated = $this->validate($this->orderRules);

        $medicine = $this->medicines->filter(fn($m) => $m->obat_id == $validated['orderList']['obat_id']);
        $name = $medicine->value('nama_obat');
        $total = $medicine->value('harga_per_box') * $validated['orderList']['kuantitas'];

        array_push($this->orders, [
            ...$validated['orderList'],
            'nama' => $name,
            'total' => $total,
            'isi_box' => $medicine->value('isi_box'),
            'harga' => $medicine->value('harga_per_box'),
        ]);
    }

    public function updated($propName, $val)
    {
        if ($propName == 'filterSupplier') {
            $this->medicines = Medicine::when($this->filterSupplier !== 'all', fn ($query) => $query->where('suppliers', $this->filterSupplier))->get();
        }
        if ($propName == 'orderList.obat_id') {
            $medicine = Medicine::find($val);
            $stock = $medicine->stocks->reduce(fn ($carry, $s) => $carry + $s->stok, 0);
            $this->info = $stock <= $medicine->minimal_stok ? 'Stok = ' . $stock . '. Stok obat sudah mencapat minimal stok' : 'Stok = ' . $stock . '.';
        }
    }

    public function submit()
    {
        if (sizeof($this->orders) == 0) {
            $this->setErrorBag([
                'orderList.obat_id' => 'Plase add medicine at least 1'
            ]);
            return;
        }
        $validated = $this->validate($this->purchaseRules);
        $purchase = Purchase::create([
            ...$validated['pembelian'],
            'status' => 'Requested',
            'total' => array_sum(array_map(fn ($a) => $a['total'],$this->orders)),
        ]);

        foreach ($this->orders as $order) {
            $medicine = Medicine::find($order['obat_id']);
            $flow = Purchase::find($purchase->pembelian_id);
            $orderList = new OrderList();
            $orderList->flow()->associate($flow);
            $orderList->medicine()->associate($medicine);
            $orderList->kuantitas = $order['kuantitas'];
            $orderList->status = 'Purchasing';
            $orderList->total = $medicine->harga_per_box * $order['kuantitas'];
            $orderList->save();
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order Requested');
    }

    public function deleteOrder($id)
    {
        array_splice($this->orders, $id, 1);
    }

    public function render()
    {
        return view('livewire.orders.request');
    }
}
