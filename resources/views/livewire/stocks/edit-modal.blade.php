<div>
    <x-adminlte-modal
        id="edit-modal"
        title="Edit Stock"
        theme="blue"
        icon="fas fa-capsules"
        size='lg'
        v-centered
        wire:ignore.self
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

                <x-adminlte-input
                    autocomplete="name"
                    name="name"
                    label="Name"
                    placeholder="Name"
                    wire:model.defer="stock.medicine.nama_obat"
                    error-key="medicine.nama_obat"
                    disabled
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="no_batch"
                    name="no_batch"
                    label="No Batch"
                    placeholder="No Batch"
                    wire:model.defer="stock.no_batch"
                    error-key="stock.no_batch"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="no_exp"
                    name="no_exp"
                    label="No Exp"
                    type="date"
                    placeholder="No Exp"
                    wire:model.defer="stock.no_exp"
                    error-key="stock.no_exp"
                    x-data
                    x-on:click="$nextTick(() => $el.showPicker())"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="harga"
                    name="harga"
                    label="Harga"
                    placeholder="Harga"
                    wire:model.defer="stock.harga_jual"
                    error-key="stock.harga_jual"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-money-bill"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="stock"
                    name="stock"
                    label="Stock"
                    placeholder="Stock"
                    wire:model.defer="stock.stok"
                    error-key="stock.stok"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-box"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-select
                    name="status"
                    label="Status"
                    wire:model.defer="stock.status"
                    error-key="stock.status"
                >
                    <option selected>Select Status</option>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Hanpir Kadaluarsa">Hampir Kadaluarsa</option>
                    <option value="Kadaluarsa">Kadaluarsa</option>
                </x-adminlte-select>

                <x-adminlte-button
                    class="btn-flat"
                    type="submit"
                    label="Submit"
                    theme="primary"
                    icon="fas fa-lg fa-save"
                />
            </div>
        </form>
    </x-adminlte-modal>
</div>
