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
                        <span class="w-75">{{ $purchase?->keterangan ?? '-' }}</span>
                    </div>
                    @if ($attachment)
                        <div class="d-flex flex-column p-2">
                            <span class="w-25 fw-bold">Bukti</span>
                            @if ($ext == 'pdf')
                                <a href="{{ $attachment }}">{{ $attachment }}</a>
                            @else
                                <img src="{{ $attachment }}" alt="bukti" />
                            @endif
                        </div>
                    @endif
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
                                                {{-- {{ $order->medicine->nama_obat }} - Rp. {{ number_format($order->total) }} --}}
                                                {{ $order->medicine->nama_obat }}
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
                                                <span class="w-25 fw-bold">Jenis</span>
                                                <span class="w-75">{{ $order->medicine->jenis }}</span>
                                            </div>
                                            {{-- <div class="d-flex">
                                                <span class="w-25 fw-bold">Harga</span>
                                                <span class="w-75">Rp. {{ number_format($order->medicine->harga) }}</span>
                                                <span class="w-75">-</span>
                                            </div> --}}
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Kuantitas</span>
                                                <span class="w-75">{{ $order->kuantitas }} Box</span>
                                            </div>
                                            {{-- <div class="d-flex">
                                                <span class="w-25 fw-bold">Total</span>
                                                <span class="w-75">Rp. {{ number_format($order->total) }}</span>
                                                <span class="w-75">-</span>
                                            </div> --}}
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Kategori</span>
                                                <span class="w-75">{{ $order->medicine->category->nama_kategori }}</span>
                                            </div>
                                            {{-- <div class="d-flex">
                                                <span class="w-25 fw-bold">Merek</span>
                                                <span class="w-75">{{ $order->medicine->brand->nama_merek }}</span>
                                            </div> --}}
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

                @can('apoteker')
                    @if ($purchase?->status == 'Approved')
                        <div class="d-flex g-2">
                            <x-adminlte-button
                                class="btn mb-3 mx-2"
                                type="button"
                                label="Print"
                                theme="primary"
                                icon="fas fa-print"
                                {{-- wire:click="print" --}}
                                data-toggle="modal"
                                data-target="#print-modal"
                            />
                            <x-adminlte-button
                                class="btn mb-3 mx-2"
                                type="button"
                                label="Download PDF"
                                theme="outline-danger"
                                icon="fas fa-file-pdf"
                                {{-- wire:click="generatePdf"
                                wire:loading.attr="disabled"
                                wire:target="generatePdf" --}}
                                data-toggle="modal"
                                data-target="#download-modal"
                            />
                        </div>
                    @endif
                @endcan
    
                @can('pemilik')
                    @if ($purchase?->status === 'Requested')
                        <x-adminlte-textarea
                            class="flex-fill"
                            autocomplete="keterangan"
                            name="keterangan"
                            label="Keterangan"
                            placeholder="Keterangan"
                            wire:model.defer="purchase.keterangan"
                            error-key="purchase.keterangan"
                        >
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-info"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-textarea>
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
                @endcan

                {{-- @can('gudang')
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
                @endcan --}}
            </div>
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal
        id="print-modal"
        title="Nama Pencetak"
        theme="success"
        icon="fas fa-print"
        size='lg'
        v-centered
        wire:ignore.self
        x-data
    >
        <x-adminlte-input
            autocomplete="nama"
            name="nama"
            label="Nama Pencetak"
            placeholder="Nama Pencetak"
            wire:model.defer="name"
            error-key="name"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-user"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="primary" label="Print" wire:click="print"/>
            <x-adminlte-button label="Dismiss" data-dismiss="print-modal"/>
        </x-slot>
    </x-adminlte-modal>

    <x-adminlte-modal
        id="download-modal"
        title="Nama Pencetak"
        theme="success"
        icon="fas fa-print"
        size='lg'
        v-centered
        wire:ignore.self
        x-data
    >
        <x-adminlte-input
            autocomplete="nama"
            name="nama"
            label="Nama Pencetak"
            placeholder="Nama Pencetak"
            wire:model.defer="name"
            error-key="name"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-user"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-slot name="footerSlot">
            <x-adminlte-button
                class="mr-auto"
                theme="primary"
                label="Download PDF"
                wire:click="generatePdf"
                wire:loading.attr="disabled"
                wire:target="generatePdf"
            />
            <x-adminlte-button label="Dismiss" data-dismiss="download-modal"/>
        </x-slot>
    </x-adminlte-modal>
</div>
