<div>
    <x-adminlte-modal
        id="add-user"
        title="Add New User"
        theme="success"
        icon="fas fa-fw fa-user"
        size='lg'
        v-centered
        wire:ignore.self
        x-data
        @close-modal-add-user.window="$('#add-user').modal('hide')"
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
                    autocomplete="username"
                    name="new-user"
                    label="Username"
                    placeholder="Username"
                    wire:model.defer="newUser.username"
                    error-key="newUser.username"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-select
                    name="new-role"
                    label="Role"
                    wire:model.defer="newUser.role"
                    error-key="newUser.role"
                >
                    <option selected disabled>Select Role</option>
                    @can('pemilik')
                        <option value="1">Pemilik</option>
                    @endcan
                    <option value="2">Gudang</option>
                    <option value="3">Apoteker</option>
                </x-adminlte-select>

                <x-adminlte-input
                    autocomplete="password"
                    name="new-password"
                    label="Password"
                    type="password"
                    placeholder="Password"
                    wire:model.defer="newUser.password"
                    error-key="newUser.password"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-key"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
    
                <x-adminlte-input
                    autocomplete="off"
                    name="new-confirm-password"
                    label="Confirm Password"
                    type="password"
                    placeholder="Repeat Password"
                    wire:model.defer="newUser.password_confirmation"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-key"></i>
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
