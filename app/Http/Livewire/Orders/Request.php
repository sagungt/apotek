<?php

namespace App\Http\Livewire\Orders;

use App\Models\Medicine;
use App\Models\OrderList;
use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;

class Request extends Component
{
    public $medicines;
    public $suppliers;
    public $orders = [];
    public $orderList;
    public $grandTotal = 0;
    public $pembelian;

    protected $orderRules = [
        'orderList.obat_id' => 'required|exists:obat,obat_id',
        'orderList.kuantitas' => 'required|min:1|numeric',
    ];
    protected $purchaseRules = [
        'pembelian.tanggal' => 'required|date',
        'pembelian.supplier_id' => 'required|exists:supplier,supplier_id',
        'pembelian.keterangan' => 'nullable',
    ];

    public function mount()
    {
        $this->medicines = Medicine::all();
        $this->suppliers = Supplier::all();
    }
    
    public function addToOrder()
    {
        $validated = $this->validate($this->orderRules);

        $medicine = $this->medicines->filter(fn($m) => $m->obat_id == $validated['orderList']['obat_id']);
        $name = $medicine->value('nama_obat');
        $total = $medicine->value('harga') * $validated['orderList']['kuantitas'];

        array_push($this->orders, [
            ...$validated['orderList'],
            'nama' => $name,
            'total' => $total,
        ]);

        $this->grandTotal = array_sum(array_map(fn ($arr) => $arr['total'], $this->orders));
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
            'total' => $this->grandTotal,
        ]);

        foreach ($this->orders as $order) {
            $medicine = Medicine::find($order['obat_id']);
            $flow = Purchase::find($purchase->pembelian_id);
            $orderList = new OrderList();
            $orderList->flow()->associate($flow);
            $orderList->medicine()->associate($medicine);
            $orderList->kuantitas = $order['kuantitas'];
            $orderList->status = 'Purchasing';
            $orderList->total = $medicine->harga * $order['kuantitas'];
            $orderList->save();
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order Requested');
    }

    public function deleteOrder($id)
    {
        array_splice($this->orders, $id, 1);
        $this->grandTotal = array_sum(array_map(fn ($arr) => $arr['total'], $this->orders));
    }

    public function render()
    {
        return view('livewire.orders.request');
    }
}
