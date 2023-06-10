<div>
    <x-adminlte-modal
        id="add-brand"
        title="Add New Brand"
        theme="success"
        icon="fas fa-copyright"
        size='lg'
        v-centered
        wire:ignore.self
        x-data
        @close-modal-add-brand.window="$('#add-brand').modal('hide')"
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
                    placeholder="Brand Name"
                    wire:model.defer="newBrand.name"
                    error-key="newBrand.name"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-edit"></i>
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
