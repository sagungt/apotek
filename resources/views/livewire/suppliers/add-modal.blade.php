<div>
    <x-adminlte-modal
        id="add-supplier"
        title="Add New Supplier"
        theme="success"
        icon="fas fa-box-open"
        size='lg'
        v-centered
        wire:ignore.self
        x-data
        @close-modal-add-supplier.window="$('#add-supplier').modal('hide')"
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
                    autocomplete="name"
                    name="new-brand"
                    label="Name"
                    placeholder="Supplier Name"
                    wire:model.defer="newSupplier.supplier_nama"
                    error-key="newSupplier.supplier_nama"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="npwp"
                    name="npwp"
                    label="NPWP"
                    placeholder="Supplier NPWP"
                    wire:model.defer="newSupplier.npwp"
                    error-key="newSupplier.npwp"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-id-card"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-textarea
                    autocomplete="address"
                    name="address"
                    label="Address"
                    placeholder="Address"
                    rows="4"
                    wire:model.defer="newSupplier.alamat"
                    error-key="newSupplier.alamat"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-map-marked"></i>
                        </div>
                    </x-slot>
                </x-adminlte-textarea>

                <x-adminlte-input
                    autocomplete="city"
                    name="city"
                    label="City"
                    placeholder="City"
                    wire:model.defer="newSupplier.kota"
                    error-key="newSupplier.kota"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-city"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="phone"
                    name="phone"
                    label="Phone"
                    placeholder="Phone Number"
                    wire:model.defer="newSupplier.telepon"
                    error-key="newSupplier.telepon"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="fax"
                    name="fax"
                    label="Fax"
                    placeholder="Fax Number"
                    wire:model.defer="newSupplier.fax"
                    error-key="newSupplier.fax"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-fax"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="email"
                    name="email"
                    label="Email"
                    placeholder="Email"
                    wire:model.defer="newSupplier.email"
                    error-key="newSupplier.email"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
    
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
