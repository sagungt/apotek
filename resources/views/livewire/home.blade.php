<div class="container-fluid">
    <div class="row" style="gap: 20px">
        <x-adminlte-info-box
            class="col-2"
            title="Penjualan"
            :text="$saleCount . ' Transaksi'"
            :description="'Rp. ' . number_format($salesDetail)"
            icon="fas fa-lg fa-chart-line text-dark"
            theme="gradient-teal"
        />
        <x-adminlte-info-box
            class="col-2"
            title="Pembelian"
            :text="$purchaseCount . ' Transaksi'"
            :description="'Rp. ' . number_format($purchasesDetail)"
            icon="fas fa-lg fa-box text-dark"
            theme="gradient-red"
        />
        <x-adminlte-info-box
            class="col-2"
            title="Stock Obat"
            :text="$stockCount . ' Obat'"
            :description="$stockDetail . ' Obat terjual'"
            icon="fas fa-lg fa-capsules text-dark"
            theme="gradient-blue"
        />
        <x-adminlte-info-box
            class="col-2"
            title="Hampir Kadaluarsa"
            :text="$almostExpiredCount . ' Obat'"
            icon="fas fa-lg fa-hourglass-half text-dark"
            theme="gradient-orange"
        />
    </div>
</div>
