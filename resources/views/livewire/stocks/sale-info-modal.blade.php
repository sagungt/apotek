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
                        <span class="w-75">{{ $sale?->penjualan_id }}</span>
                    </div>
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold" fw-bold>Faktur</span>
                        <span class="w-75">{{ $sale?->no_faktur }}</span>
                    </div>
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold">Tanggal</span>
                        <span class="w-75">{{ $sale?->tanggal }}</span>
                    </div>
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold">Tipe</span>
                        <span class="w-75">{{ $sale?->tipe }}</span>
                    </div>
                    @if ($sale?->tipe == 'Resep')
                        <div class="d-flex p-2">
                            <span class="w-25 fw-bold">Nama Dokter</span>
                            <span class="w-75">{{ $sale?->nama_dokter ?? '-' }}</span>
                        </div>
                        <div class="d-flex p-2">
                            <span class="w-25 fw-bold">Nama Pelanggan</span>
                            <span class="w-75">{{ $sale?->nama_pelanggan ?? '-' }}</span>
                        </div>
                    @endif
                </div>

                <div class="my-2 p-2">
                    <h5>Order List</h5>
                    <div id="accordion">
                        @if ($sale?->orderList)
                            @foreach ($sale?->orderList()->with('medicine')->get() as $index => $order)
                                @php($id = "collapse_$index")
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title w-100">
                                            <a class="d-block w-100" data-toggle="collapse" href="#{{ $id }}">
                                                {{ $order->medicine->medicine->nama_obat }} - Rp. {{ number_format($order->total) }}
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
                                                <span class="w-75">{{ $order->medicine->medicine->nama_obat }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Satuan</span>
                                                <span class="w-75">{{ $order->medicine->medicine->satuan }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Jenis</span>
                                                <span class="w-75">{{ $order->medicine->medicine->jenis }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Harga</span>
                                                <span class="w-75">Rp. {{ number_format($order->medicine->harga_jual + ($order->medicine->harga_jual * 0.1)) }}</span>
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
                                                <span class="w-75">{{ $order->medicine->medicine->category->nama_kategori }}</span>
                                            </div>
                                            {{-- <div class="d-flex">
                                                <span class="w-25 fw-bold">Merek</span>
                                                <span class="w-75">{{ $order->medicine->medicine->brand->nama_merek }}</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="align-self-end my-2 p-2">
                    <h4 class="fw-bold">Grand Total : Rp. {{ number_format($sale?->jumlah) }}</h4>
                </div>
            </div>
        </form>

        <x-adminlte-button
            class="btn mb-3"
            type="button"
            label="Download PDF"
            theme="danger"
            icon="fas fa-file-pdf"
            wire:click="downloadPdf"
            wire:loading.attr="disabled"
            wire:target="downloadPdf"
        />
        <x-adminlte-button
            class="btn mb-3"
            type="button"
            label="Print"
            theme="outline-danger"
            icon="fas fa-print"
            wire:click="print"
        />
    </x-adminlte-modal>
</div>
