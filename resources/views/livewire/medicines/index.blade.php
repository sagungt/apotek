<div>
    <x-adminlte-button
        class="btn mb-3"
        type="button"
        label="Add New Medicine"
        theme="outline-success"
        icon="fas fa-lg fa-plus"
        data-toggle="modal"
        data-target="#add-medicine"
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
                    <th scope="col">No Batch</th>
                    <th scope="col">No Exp</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Merek</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medicines as $medicine)
                    <tr scope="row">
                        <td>{{ $medicine->id }}</td>
                        <td>{{ $medicine->no_batch ?? '-' }}</td>
                        <td>{{ $medicine->no_exp ?? '-' }}</td>
                        <td>{{ $medicine->name ?? '-' }}</td>
                        <td>{{ $medicine->uom ?? '-' }}</td>
                        <td>{{ $medicine->category?->name ?? '-' }}</td>
                        <td>{{ $medicine->brand?->name ?? '-' }}</td>
                        <td>
                            <button
                                class="btn btn-xs btn-default text-primary mx-1"
                                title="Edit"
                                data-toggle="modal"
                                data-target="#edit-medicine"
                                wire:click="$emitTo('medicines.edit-modal', 'setMedicine', {{ $medicine->id }})"
                            >
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <button
                                class="btn btn-xs btn-default text-danger mx-1"
                                title="Delete"
                                data-toggle="modal"
                                data-target="#delete-medicine"
                                wire:click="$emitTo('medicines.delete-modal', 'setMedicineId', {{ $medicine->id }})"
                            >
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No Records found ...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $medicines->links() }}

    <livewire:medicines.edit-modal />

    <livewire:medicines.add-modal />

    <livewire:medicines.delete-modal />
</div>
