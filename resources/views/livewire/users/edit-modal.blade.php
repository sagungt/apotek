<div>
    <x-adminlte-modal
        id="edit-user"
        title="Edit User"
        theme="blue"
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

                @if (session()->has('errorEdit'))
                    <x-adminlte-alert theme="danger" title="Error">
                        {{ session()->get('errorEdit') }}
                    </x-adminlte-alert>
                @endif
    
                <x-adminlte-input
                    autocomplete="username"
                    name="user"
                    label="Username"
                    placeholder="UserName"
                    wire:model.defer="user.username"
                    error-key="user.username"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-select
                    name="role"
                    label="Role"
                    wire:model.defer="user.role"
                    error-key="user.role"
                >
                    <option selected disabled>Select Role</option>
                    @can('super-admin')
                        <option value="1">Pemilik</option>
                    @endcan
                    <option value="2">Gudang</option>
                    <option value="3">Apoteker</option>
                </x-adminlte-select>

                <x-adminlte-input
                    autocomplete="new-password"
                    name="password"
                    label="New Password"
                    type="password"
                    placeholder="Password"
                    wire:model.defer="user.new_password"
                    error-key="user.new_password"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-key"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
    
                <x-adminlte-input
                    autocomplete="off"
                    name="confirm-password"
                    label="Confirm Password"
                    type="password"
                    placeholder="Repeat Password"
                    wire:model.defer="user.new_password_confirmation"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-key"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    autocomplete="off"
                    name="shared-password"
                    label="Shared Password"
                    type="password"
                    placeholder="Shared Password"
                    wire:model.defer="user.new_shared_password"
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
                    theme="primary"
                    icon="fas fa-lg fa-save"
                />
            </div>
        </form>
    </x-adminlte-modal>
</div>
