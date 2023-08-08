<div>
    <x-adminlte-modal
        id="edit-medicine"
        title="Edit Medicine"
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

                @if (session()->has('errorEdit'))
                    <x-adminlte-alert theme="danger" title="Error">
                        {{ session()->get('errorEdit') }}
                    </x-adminlte-alert>
                @endif

                <x-adminlte-input
                    autocomplete="name"
                    name="name"
                    label="Name"
                    placeholder="Name"
                    wire:model.defer="medicine.nama_obat"
                    error-key="medicine.nama_obat"
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
                    wire:model.defer="medicine.satuan"
                    error-key="medicine.satuan"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input
                autocomplete="minimal_stok"
                name="minimal_stok"
                label="Minimal Stok"
                placeholder="Minimal Stok"
                wire:model.defer="medicine.minimal_stok"
                error-key="medicine.minimal_stok"
            >
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="suppliers"
                    name="suppliers"
                    label="suppliers"
                    {{-- type="number" --}}
                    placeholder="suppliers"
                    wire:model.defer="medicine.suppliers"
                    error-key="medicine.suppliers"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="jenis_obat"
                    name="jenis_obat"
                    label="Jenis Obat"
                    placeholder="Jenis Obat"
                    wire:model.defer="medicine.jenis"
                    error-key="medicine.jenis"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-capsules"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="isi_box"
                    name="isi_box"
                    label="Isi per box"
                    placeholder="Jumlah"
                    wire:model.defer="medicine.isi_box"
                    error-key="medicine.isi_box"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-capsules"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="harga"
                    name="harga"
                    label="Harga per box"
                    placeholder="Harga"
                    wire:model.defer="medicine.harga_per_box"
                    error-key="medicine.harga_per_box"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-money-bill"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-select
                    name="category"
                    label="Category"
                    wire:model.defer="medicine.kategori_id"
                    error-key="medicine.kategori_id"
                >
                    <option selected disabled>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->kategori_id }}">{{ $category->nama_kategori }}</option>
                    @endforeach
                </x-adminlte-select>

                {{-- <x-adminlte-select
                    name="brand"
                    label="Brand"
                    wire:model.defer="medicine.merek_id"
                    error-key="medicine.merek_id"
                >
                    <option selected disabled>Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->merek_id }}">{{ $brand->nama_merek }}</option>
                    @endforeach
                </x-adminlte-select> --}}

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
