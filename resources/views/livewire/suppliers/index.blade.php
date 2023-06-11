<div>
    <x-adminlte-button
        class="btn mb-3"
        type="button"
        label="Add New Supplier"
        theme="outline-success"
        icon="fas fa-lg fa-plus"
        data-toggle="modal"
        data-target="#add-supplier"
    />
    
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
                    <th scope="col">Nama</th>
                    <th scope="col">NPWP</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Kota</th>
                    <th scope="col">No. Telp</th>
                    <th scope="col">Fax</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr scope="row">
                        <td>{{ $supplier->supplier_id }}</td>
                        <td>{{ $supplier->supplier_nama ?? '-' }}</td>
                        <td>{{ $supplier->npwp ?? '-' }}</td>
                        <td>{{ $supplier->alamat ?? '-' }}</td>
                        <td>{{ $supplier->kota ?? '-' }}</td>
                        <td>{{ $supplier->telepon ?? '-' }}</td>
                        <td>{{ $supplier->fax ?? '-' }}</td>
                        <td>{{ $supplier->email ?? '-' }}</td>
                        <td>
                            <button
                                class="btn btn-xs btn-default text-primary mx-1"
                                title="Edit"
                                data-toggle="modal"
                                data-target="#edit-supplier"
                                wire:click="$emitTo('suppliers.edit-modal', 'setSupplier', {{ $supplier->supplier_id }})"
                            >
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <button
                                class="btn btn-xs btn-default text-danger mx-1"
                                title="Delete"
                                data-toggle="modal"
                                data-target="#delete-supplier"
                                wire:click="$emitTo('suppliers.delete-modal', 'setSupplierId', {{ $supplier->supplier_id }})"
                            >
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No Records found ...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $suppliers->links() }}

    <livewire:suppliers.edit-modal />

    <livewire:suppliers.add-modal />

    <livewire:suppliers.delete-modal />
</div>
