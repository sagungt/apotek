<div>
    @can('apoteker')
        <a href="{{ route('orders.request') }}">
            <x-adminlte-button
                class="btn mb-3"
                type="button"
                label="Request Stock"
                theme="outline-success"
                icon="fas fa-lg fa-plus"
            />
        </a>
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
                    <th scope="col">Supplier</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    @unless ($isHistory)
                        <th scope="col">Action</th>
                    @endunless
                </tr>
            </thead>
            <tbody>
                @forelse ($purchases as $purchase)
                    <tr scope="row">
                        <td>{{ $purchase->pembelian_id }}</td>
                        <td>{{ $purchase->no_faktur ?? 'Waiting for payment' }}</td>
                        <td>{{ $purchase->supplier->supplier_nama }}</td>
                        <td>{{ $purchase->tanggal }}</td>
                        <td>{{ number_format($purchase->total) }}</td>
                        <td>
                            <span
                                @class([
                                    'badge',
                                    'badge-primary' => in_array($purchase->status, ['Requested']),
                                    'badge-danger' => in_array($purchase->status, ['Rejected']),
                                    'badge-success' => in_array($purchase->status, ['Approved', 'Complete', 'Purchasing'])
                                ])
                            >
                                {{ $purchase->status }}
                            </span>
                        </td>
                        @unless ($isHistory)
                            <td>
                                @can('gudang')
                                    @if ($purchase->status === 'Purchasing')
                                        <button
                                            class="btn btn-xs btn-default text-success mx-1"
                                            title="Confirm"
                                            data-toggle="modal"
                                            data-target="#confirm-modal"
                                            wire:click="$emitTo('stocks.confirm-modal', 'setPurchase', {{ $purchase->pembelian_id }})"
                                        >
                                            <i class="fa fa-lg fa-fw fa-check"></i>
                                        </button>
                                    @endif
                                @endcan
                                <button
                                    class="btn btn-xs btn-default text-primary mx-1"
                                    title="Show"
                                    data-toggle="modal"
                                    data-target="#detail-order"
                                    wire:click="$emitTo('stocks.detail-modal', 'setPurchase', {{ $purchase->pembelian_id }})"
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

    {{ $purchases->links() }}

    @if ($isHistory)
        @can('pemilik')
            @if ($totalMonth)
                <h3>Total Bulan ini: Rp. {{ number_format($totalMonth ?? 0) }}</h3>
            @endif
        @endcan
    @endif

    <livewire:stocks.detail-modal />

    <livewire:stocks.confirm-modal />
</div>
