<div class="mx-auto">
    <div class="container-sm shadow p-4 rounded d-flex flex-column">
        <x-adminlte-input
            autocomplete="tanggal"
            name="tanggal"
            label="Tanggal"
            type="date"
            placeholder="Tanggal"
            wire:model.defer="pembelian.tanggal"
            error-key="pembelian.tanggal"
            x-data
            x-on:click="$nextTick(() => $el.showPicker())"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-clock"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-select
            name="obat"
            label="Obat"
            wire:model.defer="pembelian.supplier_id"
            error-key="pembelian.supplier_id"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-box-open"></i>
                </div>
            </x-slot>
            <option selected>Select Supplier</option>
            @forelse ($suppliers as $supplier)
                <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_nama }}</option>
            @empty
                <option value="" disabled>No Supplier Found</option>
            @endforelse
        </x-adminlte-select>

        <hr>

        <div class="p-2 border rounded">
            <h4>Daftar Obat</h4>
    
            <x-adminlte-select
                name="obat"
                label="Obat"
                wire:model.defer="orderList.obat_id"
                error-key="orderList.obat_id"
            >
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-capsules"></i>
                    </div>
                </x-slot>
                <option selected>Select Medicine</option>
                @forelse ($medicines as $medicine)
                    <option value="{{ $medicine->obat_id }}">{{ $medicine->nama_obat }}</option>
                @empty
                    <option value="" disabled>No Medicine Found</option>
                @endforelse
            </x-adminlte-select>
    
            <x-adminlte-input
                autocomplete="kuantitas"
                name="kuantitas"
                label="Kuantitas"
                type="number"
                placeholder="Kuantitas"
                wire:model.defer="orderList.kuantitas"
                error-key="orderList.kuantitas"
            >
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-plus"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
    
            <x-adminlte-button
                class="btn"
                type="button"
                label="Add to List"
                theme="outline-success"
                icon="fas fa-plus"
                wire:click="addToOrder"
            />
    
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Obat</th>
                            <th scope="col">Kuantitas</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $index => $order)
                            <tr scope="row">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order['nama'] }}</td>
                                <td>{{ $order['kuantitas'] }} Box</td>
                                <td>
                                    <button
                                        class="btn btn-xs btn-default text-danger mx-1"
                                        title="Delete"
                                        wire:click="deleteOrder({{ $index }})"
                                    >
                                        <i class="fa fa-lg fa-fw fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Records found ...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        <hr>

        <x-adminlte-textarea
            autocomplete="keterangan"
            name="keterangan"
            label="Keterangan"
            placeholder="Keterangan"
            rows="4"
            wire:model.defer="pembelian.keterangan"
            error-key="pembelian.keterangan"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-info"></i>
                </div>
            </x-slot>
        </x-adminlte-textarea>

        <hr>

        <x-adminlte-button
            :disabled="sizeof($orders) === 0"
            class="btn btn-lg align-self-end"
            type="button"
            label="Order"
            theme="success"
            icon="fas fa-cart-plus"
            wire:click="submit"
        />
    </div>
</div>
