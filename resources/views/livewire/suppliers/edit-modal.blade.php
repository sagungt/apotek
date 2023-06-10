<div>
    <x-adminlte-modal
        id="edit-supplier"
        title="Edit Supplier"
        theme="blue"
        icon="fas fa-box-open"
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
                    name="new-brand"
                    label="Name"
                    placeholder="Brand Name"
                    wire:model.defer="supplier.name"
                    error-key="supplier.name"
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
                    placeholder="Brand NPWP"
                    wire:model.defer="supplier.npwp"
                    error-key="supplier.npwp"
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
                    wire:model.defer="supplier.address"
                    error-key="supplier.address"
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
                    wire:model.defer="supplier.city"
                    error-key="supplier.city"
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
                    wire:model.defer="supplier.phone"
                    error-key="supplier.phone"
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
                    wire:model.defer="supplier.fax"
                    error-key="supplier.fax"
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
                    wire:model.defer="supplier.email"
                    error-key="supplier.email"
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
                    theme="primary"
                    icon="fas fa-lg fa-save"
                />
            </div>
        </form>
    </x-adminlte-modal>
</div>
