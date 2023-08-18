<div>
    @can('apoteker')
        <a href="{{ route('sales.sell') }}">
            <x-adminlte-button
                class="btn mb-3"
                type="button"
                label="Jual"
                theme="outline-success"
                icon="fas fa-lg fa-plus"
            />
        </a>
    @endcan

    @can('pemilik')
        @if (sizeof($sales) > 0)
            <x-adminlte-button
                class="btn mb-3"
                type="button"
                label="Print"
                theme="primary"
                icon="fas fa-print"
                {{-- wire:click="print" --}}
                data-toggle="modal"
                data-target="#print"
            />
            <x-adminlte-button
                class="btn mb-3"
                type="button"
                label="Download PDF"
                theme="outline-danger"
                icon="fas fa-file-pdf"
                {{-- wire:click="generatePdf"
                wire:loading.attr="disabled"
                wire:target="generatePdf" --}}
                data-toggle="modal"
                data-target="#download"

            />
        @endif
    @endcan
    
    <x-adminlte-input
        name="search"
        label="Search"
        placeholder="search"
        igroup-size="md"
        wire:model="search"
    >
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="fas fa-search"></i>
            </div>
        </x-slot>
    </x-adminlte-input>

    <div class="w-100 d-flex align-items-center">
        <x-adminlte-input
            name="start_date"
            type="date"
            label="Filter Start Date"
            wire:model.defer="startDate"
            error-key="startDate"
            class="mr-2"
            x-data
            x-on:click="$nextTick(() => $el.showPicker())"
        >
        </x-adminlte-input>

        <x-adminlte-input
            name="end_date"
            label="Filter End Date"
            type="date"
            wire:model.defer="endDate"
            error-key="endDate"
            class="mr-2"                    
            x-data
            x-on:click="$nextTick(() => $el.showPicker())"
        >
        </x-adminlte-input>

        <x-adminlte-button
            theme="primary"
            label="Submit"
            wire:click="filterDate"
            class="mr-2"
            style="height: fit-content; transform: translateY(8px)"
        />
        <x-adminlte-button
            theme="outline-primary"
            label="Reset"
            wire:click="resetFilterDate"
            class="mr-2"
            style="height: fit-content; transform: translateY(8px)"
        />
    </div>
    @if ($isHistory)
        @can('pemilik')
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <x-adminlte-button
                        class="btn mb-3"
                        type="button"
                        label="Prev Month"
                        theme="outline-success"
                        icon="fas fa-lg fa-arrow-left"
                        wire:click="subMonth"
                    />
                </div>

                <div>
                    <div
                        x-data="
                            {
                                isInput: false,
                            }
                        "
                    >
                        <div
                            x-show="isInput"
                            x-on:click.outside="isInput = false"
                        >
                            <x-adminlte-input
                                name="tanggal"
                                placeholder="Tanggal ex: 2023-01"
                                wire:model.debounce="date"
                                error-key="date"
                            >
                                <x-slot name="appendSlot">
                                    <x-adminlte-button
                                        theme="outline-primary"
                                        label="Reset"
                                        wire:click="resetDate"
                                    />
                                </x-slot>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-primary">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        <div
                            x-show="!isInput"
                            x-on:click="isInput = true"
                            x-on:click.outside="isInput = false"
                        >
                            {{ $currentMonth->format('F Y') }}
                        </div>
                    </div>
                </div>

                <div>
                    <x-adminlte-button
                        class="btn mb-3"
                        type="button"
                        label="Next Month"
                        theme="outline-success"
                        icon="fas fa-lg fa-arrow-right"
                        wire:click="addMonth"
                    />
                </div>
            </div>
        @endcan
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">No Faktur</th>
                    <th scope="col">Tanggal</th>
                    @unless ($isHistory)
                        <th scope="col">Total</th>
                    @endunless
                    <th scope="col">Tipe</th>
                    @if ($isHistory)
                        <th scope="col">Barang</th>
                    @endif
                    @unless ($isHistory)
                        <th scope="col">Action</th>
                    @endunless
                </tr>
            </thead>
            <tbody>
                @forelse ($sales as $sale)
                    <tr scope="row">
                        <td>{{ $sale->penjualan_id }}</td>
                        <td>{{ $sale->no_faktur }}</td>
                        <td>{{ $sale->tanggal }}</td>
                        @unless ($isHistory)
                            <td>{{ 'Rp. ' . number_format($sale->jumlah) }}</td>
                        @endunless
                        <td>
                            @if ($sale->tipe == 'Resep')
                                <p>Resep</p>
                                <p>Nama Dokter: {{ $sale->nama_dokter ?? '' }}</p>
                                <p>Nama Pelanggan: {{ $sale->nama_pelanggan ?? '' }}</p>
                                <p>Nomor Resep: {{ $sale->no_resep ?? '' }}</p>
                            @else
                                <p>Non Resep</p>
                            @endif
                        </td>
                        @if ($isHistory)
                            <td>
                                <table>
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Jumlah</th>
                                        <th>Laba Kotor</th>
                                        <th>Laba Bersih</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($sale->orderList as $index => $order)
                                            <tr scope="row">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order->medicine->medicine->nama_obat }}</td>
                                                <td>{{ 'Rp. ' . number_format($order->medicine->harga_jual) }}</td>
                                                <td>{{ 'Rp. ' . number_format($order->medicine->finalPrice()) }}</td>
                                                <td>{{ $order->kuantitas }}</td>
                                                <td>{{ 'Rp. ' . number_format($order->grossProfit()) }}</td>
                                                <td>{{ 'Rp. ' . number_format($order->netProfit()) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr scope="row">
                                            <th colspan="5">Total Pemasukan</th>
                                            <th>{{ 'Rp. ' . number_format($sale->orderList->reduce(fn ($carry, $order) => $carry + $order->grossProfit(), 0)) }}</th>
                                            <th>{{ 'Rp. ' . number_format($sale->orderList->reduce(fn ($carry, $order) => $carry + $order->netProfit(), 0)) }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        @endif
                        @unless ($isHistory)
                            <td>
                                <button
                                    class="btn btn-xs btn-default text-primary mx-1"
                                    title="Show"
                                    data-toggle="modal"
                                    data-target="#detail-order"
                                    wire:click="$emitTo('stocks.sale-info-modal', 'setSale', {{ $sale->penjualan_id }})"
                                >
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </button>
                            </td>
                        @endunless
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Records found ...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $sales->links() }}

    @if ($isHistory)
        @can('pemilik')
            @if ($totalMonth)
                <h3>Total Bulan ini: Rp. {{ number_format($totalMonth ?? 0) }}</h3>
            @endif
        @endcan
    @endif

    <livewire:stocks.sale-info-modal />

    <x-adminlte-modal
        id="print"
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

        <x-adminlte-input
            name="print_start_date"
            type="date"
            label="Start Date"
            wire:model.defer="printStartDate1"
            error-key="printStartDate1"
            x-data
            x-on:click="$nextTick(() => $el.showPicker())"
        >
        </x-adminlte-input>

        <x-adminlte-input
            name="print_end_date"
            label="End Date"
            type="date"
            wire:model.defer="printEndDate1"
            error-key="printEndDate1"
            x-data
            x-on:click="$nextTick(() => $el.showPicker())"
        >
        </x-adminlte-input>

        <x-slot name="footerSlot">
            <x-adminlte-button
                class="mr-auto"
                theme="primary"
                label="Print"
                wire:click="print"
            />
            <x-adminlte-button label="Dismiss" data-dismiss="print"/>
        </x-slot>
    </x-adminlte-modal>

    <x-adminlte-modal
        id="download"
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

        <x-adminlte-input
            name="print_start_date"
            type="date"
            label="Start Date"
            wire:model.defer="printStartDate"
            error-key="printStartDate"
            x-data
            x-on:click="$nextTick(() => $el.showPicker())"
        >
        </x-adminlte-input>

        <x-adminlte-input
            name="print_end_date"
            label="End Date"
            type="date"
            wire:model.defer="printEndDate"
            error-key="printEndDate"
            x-data
            x-on:click="$nextTick(() => $el.showPicker())"
        >
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
            <x-adminlte-button label="Dismiss" data-dismiss="download"/>
        </x-slot>
    </x-adminlte-modal>
</div>
