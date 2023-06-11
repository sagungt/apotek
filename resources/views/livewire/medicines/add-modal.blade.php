<div>
    <x-adminlte-modal
        id="add-medicine"
        title="Add New Medicine"
        theme="success"
        icon="fas fa-capsules"
        size='lg'
        v-centered
        wire:ignore.self
        x-data
        @close-modal-add-medicine.window="$('#add-medicine').modal('hide')"
    >
        <form wire:submit.prevent="submit">
            <div class="d-flex flex-column">
                
                @if (session()->has('success'))
                    <x-adminlte-alert theme="success" title="Success">
                        {{ session()->get('success') }}
                    </x-adminlte-alert>
                @endif

                @if (session()->has('errorAdd'))
                    <x-adminlte-alert theme="danger" title="Error">
                        {{ session()->get('errorEdit') }}
                    </x-adminlte-alert>
                @endif
    
                <x-adminlte-input
                    autocomplete="no_batch"
                    name="no_batch"
                    label="No Batch"
                    placeholder="No Batch"
                    wire:model.defer="newMedicine.no_batch"
                    error-key="newMedicine.no_batch"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="no_exp"
                    name="no_exp"
                    label="No Exp"
                    type="date"
                    placeholder="No Exp"
                    wire:model.defer="newMedicine.no_exp"
                    error-key="newMedicine.no_exp"
                    x-data
                    x-on:click="$el.showPicker()"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-hourglass"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="name"
                    name="name"
                    label="Name"
                    placeholder="Name"
                    wire:model.defer="newMedicine.nama_obat"
                    error-key="newMedicine.nama_obat"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="uom"
                    name="uom"
                    label="Unit of Measurement"
                    placeholder="Unit of Measurement"
                    wire:model.defer="newMedicine.satuan"
                    error-key="newMedicine.satuan"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="harga"
                    name="harga"
                    label="Price"
                    type="number"
                    placeholder="Price"
                    wire:model.defer="newMedicine.harga"
                    error-key="newMedicine.harga"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-select
                    name="category"
                    label="Category"
                    wire:model.defer="newMedicine.kategori_id"
                    error-key="newMedicine.kategori_id"
                >
                    <option selected disabled>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->kategori_id }}">{{ $category->nama_kategori }}</option>
                    @endforeach
                </x-adminlte-select>

                <x-adminlte-select
                    name="brand"
                    label="Brand"
                    wire:model.defer="newMedicine.merek_id"
                    error-key="newMedicine.merek_id"
                >
                    <option selected disabled>Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->merek_id }}">{{ $brand->nama_merek }}</option>
                    @endforeach
                </x-adminlte-select>
    
                <x-adminlte-button
                    class="btn-flat"
                    type="submit"
                    label="Submit"
                    theme="success"
                    icon="fas fa-lg fa-save"
                />
            </div>
        </form>
    </x-adminlte-modal>
</div>
