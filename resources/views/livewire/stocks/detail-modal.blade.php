<div>
    <x-adminlte-modal
        id="detail-order"
        title="Order Detail"
        theme="success"
        icon="fas fa-shopping-chart"
        size='lg'
        v-centered
        wire:ignore.self
        x-data
        @close-modal-detail-order.window="$('#detail-order').modal('hide')"
    >
        <form wire:submit.prevent="submit">
            <div class="d-flex flex-column">
                
                @if (session()->has('success'))
                    <x-adminlte-alert theme="success" title="Success">
                        {{ session()->get('success') }}
                    </x-adminlte-alert>
                @endif

                @if (session()->has('error'))
                    <x-adminlte-alert theme="danger" title="Error">
                        {{ session()->get('error') }}
                    </x-adminlte-alert>
                @endif

                <div class="d-flex flex-column my-2">
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold">ID</span>
                        <span class="w-75">{{ $purchase?->pembelian_id }}</span>
                    </div>
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold" fw-bold>Faktur</span>
                        <span class="w-75">{{ $purchase?->no_faktur ?? 'Waiting for payment' }}</span>
                    </div>
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold">Tanggal</span>
                        <span class="w-75">{{ $purchase?->tanggal }}</span>
                    </div>
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold">Supplier</span>
                        <span class="w-75">{{ $purchase?->supplier?->supplier_nama }}</span>
                    </div>
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold">Status</span>
                        <span class="w-75">{{ $purchase?->status }}</span>
                    </div>
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold">Keterangan</span>
                        <span class="w-75">{{ $purchase?->keterangan }}1</span>
                    </div>
                </div>

                <div class="my-2 p-2">
                    <h5>Order List</h5>
                    <div id="accordion">
                        @if ($purchase?->orderList)
                            @foreach ($purchase?->orderList()->with('medicine')->get() as $index => $order)
                                @php($id = "collapse_$index")
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title w-100">
                                            <a class="d-block w-100" data-toggle="collapse" href="#{{ $id }}">
                                                {{ $order->medicine->nama_obat }} - Rp. {{ number_format($order->total) }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="{{ $id }}" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">ID Obat</span>
                                                <span class="w-75">{{ $order->obat_id }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Nama</span>
                                                <span class="w-75">{{ $order->medicine->nama_obat }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Satuan</span>
                                                <span class="w-75">{{ $order->medicine->satuan }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Tipe</span>
                                                <span class="w-75">{{ $order->medicine->tipe }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Harga</span>
                                                <span class="w-75">Rp. {{ number_format($order->medicine->harga) }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Kuantitas</span>
                                                <span class="w-75">{{ $order->kuantitas }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Total</span>
                                                <span class="w-75">Rp. {{ number_format($order->total) }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Kategori</span>
                                                <span class="w-75">{{ $order->medicine->category->nama_kategori }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Merek</span>
                                                <span class="w-75">{{ $order->medicine->brand->nama_merek }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="align-self-end my-2 p-2">
                    <h4 class="fw-bold">Grand Total : Rp. {{ number_format($purchase?->total) }}</h4>
                </div>
    
                @if ($purchase?->status === 'Requested')
                    <div class="d-flex">
                        <x-adminlte-button
                            class="btn-flat flex-fill m-2"
                            type="button"
                            label="Approve"
                            theme="success"
                            icon="fas fa-lg fa-check"
                            wire:click="approve"
                        />
                        <x-adminlte-button
                            class="btn-flat flex-fill m-2"
                            type="button"
                            label="Reject"
                            theme="danger"
                            icon="fas fa-lg fa-times"
                            wire:click="reject"
                        />
                    </div>
                @endif

                @can('gudang')
                    @if ($purchase?->status === 'Approved')
                        <x-adminlte-button
                            class="btn-flat flex-fill m-2"
                            type="button"
                            label="Order & Pay"
                            theme="primary"
                            icon="fas fa-lg fa-shopping-basket"
                            wire:click="orderAndPay"
                        />
                    @endif
                @endcan
            </div>
        </form>
    </x-adminlte-modal>
</div>
