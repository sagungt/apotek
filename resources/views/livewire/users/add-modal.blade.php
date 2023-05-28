<div>
    <x-adminlte-modal
        id="add-user"
        title="Add New User"
        theme="success"
        icon="fas fa-fw fa-user"
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

                @if (session()->has('errorAdd'))
                    <x-adminlte-alert theme="danger" title="Error">
                        {{ session()->get('errorEdit') }}
                    </x-adminlte-alert>
                @endif
    
                <x-adminlte-input
                    autocomplete="full-name"
                    name="new-user"
                    label="Name"
                    placeholder="Full Name"
                    wire:model.defer="newUser.name"
                    error-key="newUser.name"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
    
                <x-adminlte-input
                    name="new-email"
                    label="E-Mail"
                    type="email"
                    placeholder="email@example.com"
                    wire:model.defer="newUser.email"
                    error-key="newUser.email"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-at"></i>
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
                    @can('super-admin')
                        <option value="1">Super Admin</option>
                    @endcan
                    <option value="2">Admin</option>
                    <option value="3">User</option>
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
