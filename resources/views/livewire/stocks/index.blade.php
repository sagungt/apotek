<div>
    <a href="{{ route('orders.request') }}">
        <x-adminlte-button
            class="btn mb-3"
            type="button"
            label="Request Stock"
            theme="outline-success"
            icon="fas fa-lg fa-plus"
        />
    </a>
    
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

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">No Faktur</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchases as $purchase)
                    <tr scope="row">
                        <td>{{ $purchase->pembelian_id }}</td>
                        <td>{{ $purchase->no_faktur ?? 'Waiting for payment' }}</td>
                        <td>{{ $purchase->tanggal }}</td>
                        <td>{{ number_format($purchase->total) }}</td>
                        <td>{{ $purchase->status }}</td>
                        <td>
                            @can('gudang')
                                @if ($purchase->status === 'Purchasing')
                                    
                                @endif
                            @endcan
                            <button
                                class="btn btn-xs btn-default text-success mx-1"
                                title="Confirm"
                                data-toggle="modal"
                                data-target="#confirm-modal"
                                wire:click="$emitTo('stocks.confirm-modal', 'setPurchase', {{ $purchase->pembelian_id }})"
                            >
                                <i class="fa fa-lg fa-fw fa-check"></i>
                            </button>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No Records found ...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $purchases->links() }}

    <livewire:stocks.detail-modal />

    <livewire:stocks.confirm-modal />
</div>
