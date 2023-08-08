<div>
    <x-adminlte-modal
        id="confirm-modal"
        title="Order Detail"
        theme="success"
        icon="fas fa-shopping-chart"
        size='lg'
        v-centered
        wire:ignore.self
        x-data
        @close-modal-confirm.window="$('#confirm-modal').modal('hide')"
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

                <x-adminlte-alert theme="warning" title="Perhatian">
                    Pastikan semua order sesuai!
                </x-adminlte-alert>

                <div class="d-flex flex-column my-2">
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold">ID</span>
                        <span class="w-75">{{ $purchase?->pembelian_id }}</span>
                    </div>
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold">Tanggal</span>
                        <span class="w-75">{{ $purchase?->tanggal }}</span>
                    </div>
                    {{-- <div class="d-flex p-2">
                        <span class="w-25 fw-bold">Supplier</span>
                        <span class="w-75">{{ $purchase?->supplier?->supplier_nama }}</span>
                    </div> --}}
                    <div class="d-flex p-2">
                        <span class="w-25 fw-bold">Status</span>
                        <span class="w-75">{{ $purchase?->status }}</span>
                    </div>

                    <x-adminlte-input
                        class="fiex-fill"
                        autocomplete="no_faktur"
                        name="no_faktur"
                        label="No Faktur"
                        placeholder="No Faktur"
                        wire:model.defer="purchase.no_faktur"
                        error-key="purchase.no_faktur"
                        :disabled="$purchase?->status !== 'Approved'"
                    >
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-receipt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    
                    <x-adminlte-input
                        class="fiex-fill"
                        autocomplete="total"
                        name="total"
                        label="Total"
                        type="number"
                        wire:model.defer="purchase.total"
                        error-key="purchase.total"
                        :disabled="$purchase?->status !== 'Approved'"
                    >
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-money-bill"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>

                    <x-adminlte-input
                        class="fiex-fill"
                        autocomplete="tanggal"
                        name="tanggal"
                        label="Tanggal Terima"
                        type="date"
                        wire:model.defer="purchase.tanggal_terima"
                        error-key="purchase.tanggal_terima"
                        x-data
                        x-on:click="$nextTick(() => $el.showPicker())"
                        :disabled="$purchase?->status !== 'Approved'"
                    >
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>

                    {{-- @can('pemilik')
                        <x-adminlte-textarea
                            class="flex-fill"
                            autocomplete="keterangan"
                            name="keterangan"
                            label="Keterangan"
                            placeholder="Keterangan"
                            wire:model.defer="purchase.keterangan"
                            error-key="purchase.keterangan"
                            :disabled="$purchase?->status !== 'Approved'"
                        >
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-info"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-textarea>
                    @endcan --}}

                    @if ($purchase?->status === 'Approved')
                        <x-adminlte-input-file
                            name="bukti"
                            id="bukti"
                            label="Bukti"
                            placeholder="Choose a file..."
                            wire:model="attachment"
                            error-key="attachment"
                        >
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>
                    @endif

                    @if ($attachment)
                        @if ($attachment->getClientOriginalExtension() === 'pdf')
                            <span>{{ $attachment->getClientOriginalName() }}</span>
                        @else
                            <img src="{{ $attachment->temporaryUrl() }}" alt="bukti">
                        @endif
                    @endif
                </div>

                <div class="my-2 p-2">
                    <h5>Order List</h5>
                    <div id="accordion">
                        @if ($purchase?->orderList)
                            @foreach ($orders as $index => $order)
                                @php($id = "collapse_$index")
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title w-100">
                                            <a class="d-block w-100" data-toggle="collapse" href="#{{ $id }}" aria-expanded="true" data-bs-target="#{{ $id }}" aria-controls="{{ $id }}" data-bs-toggle="collapse">
                                                {{-- {{ $order->medicine->nama_obat }} - Rp. {{ number_format($order->total) }} --}}
                                                {{ $order->medicine->nama_obat }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="{{ $id }}" class="collapse" data-parent="#accordion">
                                        <div class="card-body d-flex flex-column">
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
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Isi per box</span>
                                                <span class="w-75">{{ $order->medicine->isi_box }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Harga per box</span>
                                                <span class="w-75">Rp. {{ number_format($order->medicine->harga_per_box) }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Kuantitas</span>
                                                <span class="w-75">{{ $order->kuantitas }} Box</span>
                                            </div>
                                            {{-- <div class="d-flex">
                                                <span class="w-25 fw-bold">Total</span>
                                                <span class="w-75">Rp. {{ number_format($order->total) }}</span>
                                            </div> --}}
                                            <div class="d-flex">
                                                <span class="w-25 fw-bold">Kategori</span>
                                                <span class="w-75">{{ $order->medicine->category->nama_kategori }}</span>
                                            </div>
                                            {{-- <div class="d-flex">
                                                <span class="w-25 fw-bold">Merek</span>
                                                <span class="w-75">{{ $order->medicine->brand->nama_merek }}</span>
                                            </div> --}}
                                            @if ($purchase->status === 'Approved')
                                                <div class="flex-fill">
                                                    <x-adminlte-input
                                                        autocomplete="no_batch"
                                                        name="no_batch"
                                                        label="No Batch"
                                                        placeholder="No Batch"
                                                        wire:model.defer="orders.{{ $index }}.no_batch"
                                                        error-key="orders.{{ $index }}.no_batch"
                                                        :disabled="$purchase?->status !== 'Approved'"
                                                    >
                                                        <x-slot name="prependSlot">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-receipt"></i>
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input>
                                                </div>
                                                <div class="flex-fill">
                                                    <x-adminlte-input
                                                        autocomplete="harga"
                                                        name="harga"
                                                        label="Harga"
                                                        type="number"
                                                        placeholder="Harga"
                                                        wire:model.defer="orders.{{ $index }}.harga_jual"
                                                        error-key="orders.{{ $index }}.harga_jual"
                                                        :disabled="$purchase?->status !== 'Approved'"
                                                    >
                                                        <x-slot name="prependSlot">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-money-bill"></i>
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input>
                                                </div>
                                                <div class="flex-fill">
                                                    <x-adminlte-input
                                                        autocomplete="no_exp"
                                                        name="no_exp"
                                                        label="No Exp"
                                                        type="date"
                                                        placeholder="No Exp"
                                                        wire:model.defer="orders.{{ $index }}.no_exp"
                                                        error-key="orders.{{ $index }}.no_exp"
                                                        x-data
                                                        x-on:click="$nextTick(() => $el.showPicker())"
                                                        :disabled="$purchase?->status !== 'Approved'"

                                                    >
                                                        <x-slot name="prependSlot">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-hourglass-half"></i>
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input>
                                                </div>
                                                <div class="flex-fill">
                                                    <x-adminlte-input
                                                        autocomplete="kuantitas"
                                                        name="kuantitas"
                                                        label="Kuantitas"
                                                        type="number"
                                                        placeholder="Kuantitas"
                                                        wire:model.defer="qty.{{ $index }}"
                                                        error-key="qty.{{ $index }}"
                                                        :disabled="$purchase?->status !== 'Approved'"

                                                    >
                                                        <x-slot name="prependSlot">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-plus"></i>
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- <div class="align-self-end my-2 p-2">
                    <h4 class="fw-bold">Grand Total : Rp. {{ number_format($purchase?->total) }}</h4>
                </div> --}}

                @can('gudang')
                    @if ($purchase?->status === 'Approved')
                        <x-adminlte-button
                            class="btn-flat flex-fill m-2"
                            type="button"
                            label="Confirm"
                            theme="primary"
                            icon="fas fa-lg fa-check"
                            wire:click="confirm"
                        />
                    @endif
                @endcan
            </div>
        </form>
    </x-adminlte-modal>
</div>
