<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sell;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }

    public function request()
    {
        return view('orders.request');
    }

    public function sales()
    {
        return view('orders.sales');
    }

    public function sell()
    {
        return view('orders.sell');
    }

    public function salesHistory()
    {
        return view('history.sales');
    }

    public function purchasesHistory()
    {
        return view('history.purchases');
    }

    public function printSaleInfo(Request $request, $id = null)
    {
        $sale = Sell::with('orderList', 'orderList.medicine', 'orderList.medicine.medicine')->find($id);
        return Pdf::loadView('pdf.invoice', $sale?->toArray())->stream();
    }

    public function printPurchases(Request $request, $date)
    {
        $currentMonth = Carbon::parse($date);
        $purchases = Purchase::query()
            ->whereIn('status', ['Complete'])
            ->where(function ($query) use ($currentMonth) {
                $first = Carbon::parse($currentMonth)->startOfMonth();
                $last = Carbon::parse($currentMonth)->endOfMonth();
                return $query
                    ->whereDate('tanggal', '>=', $first)
                    ->whereDate('tanggal', '<=', $last);
                })
            ->get();
        return Pdf::loadView('pdf.pembelian', ['pembelian' => $purchases, 'tanggal' => $currentMonth->format('Y-m')])->stream();
    }

    public function printSales(Request $request, $date)
    {
        $currentMonth = Carbon::parse($date);
        $sales = Sell::query()
            ->where(function ($query) use ($currentMonth) {
                $first = Carbon::parse($currentMonth)->startOfMonth();
                $last = Carbon::parse($currentMonth)->endOfMonth();
                return $query
                    ->whereDate('tanggal', '>=', $first)
                    ->whereDate('tanggal', '<=', $last);
            })
            ->get();
        return Pdf::loadView('pdf.penjualan', ['penjualan' => $sales, 'tanggal' => $currentMonth->format('Y-m')])->stream();
    }

    public function print($id)
    {
        $request = Purchase::with('orderList', 'orderList.medicine', 'supplier')->find($id);
        return Pdf::loadView('pdf.request', ['request' => $request, 'tanggal' => $request->tanggal])->stream();
    }
}
