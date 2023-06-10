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

                <x-adminlte-input-date
                    autocomplete="no_exp"
                    name="no_exp"
                    label="No Exp"
                    placeholder="No Exp"
                    :config="['format' => 'DD/MM/YY']"
                    wire:model.defer="newMedicine.no_exp"
                    error-key="newMedicine.no_exp"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-hourglass"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>

                <x-adminlte-input
                    autocomplete="name"
                    name="name"
                    label="Name"
                    placeholder="Name"
                    wire:model.defer="newMedicine.name"
                    error-key="newMedicine.name"
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
                    wire:model.defer="newMedicine.uom"
                    error-key="newMedicine.uom"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-select
                    name="category"
                    label="Category"
                    wire:model.defer="newMedicine.category_id"
                    error-key="newMedicine.category_id"
                >
                    <option selected disabled>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-adminlte-select>

                <x-adminlte-select
                    name="brand"
                    label="Brand"
                    wire:model.defer="newMedicine.brand_id"
                    error-key="newMedicine.brand_id"
                >
                    <option selected disabled>Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
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
