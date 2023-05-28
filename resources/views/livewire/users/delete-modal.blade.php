<div>
    <x-adminlte-modal
        id="delete-user"
        title="Are you sure want to delete this user ?"
        theme="red"
        icon="fas fa-trash"
        size='lg'
        v-centered
        wire:ignore.self
        x-data
        @close-modal-delete-user.window="$('#delete-user').modal('hide')"
    >
        @if (session()->has('successDelete'))
            <x-adminlte-alert theme="danger" title="Danger">
                {{ session()->get('successDelete') }}
            </x-adminlte-alert>
        @else
            <div class="d-flex justify-content-center">
                <x-adminlte-button
                    class="btn-lg"
                    type="button"
                    label="Delete"
                    theme="danger"
                    icon="fas fa-lg fa-trash"
                    wire:click="delete"
                />
            </div>
        @endif
    </x-adminlte-modal>
</div>
