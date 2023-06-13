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
                        <td>{{ $purchase->no_faktur }}</td>
                        <td>{{ $purchase->taggal }}</td>
                        <td>{{ $purchase->total }}</td>
                        <td>{{ $purchase->status }}</td>
                        <td>
                            {{-- <button
                                class="btn btn-xs btn-default text-primary mx-1"
                                title="Edit"
                                data-toggle="modal"
                                data-target="#edit-brand"
                                wire:click="$emitTo('brands.edit-modal', 'setBrand', {{ $brand->id }})"
                            >
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <button
                                class="btn btn-xs btn-default text-danger mx-1"
                                title="Delete"
                                data-toggle="modal"
                                data-target="#delete-brand"
                                wire:click="$emitTo('brands.delete-modal', 'setBrandId', {{ $brand->id }})"
                            >
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button> --}}
                            <button
                                class="btn btn-xs btn-default text-primary mx-1"
                                title="Show"
                                data-toggle="modal"
                                data-target="#show-request"
                                wire:click="$emitTo('stocks.show-modal', 'setPurchaseId', {{ $purchase->pembelian_id }})"
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
</div>
