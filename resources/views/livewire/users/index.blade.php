<div>
    @if (session()->has('error'))
        <x-adminlte-alert theme="danger" title="Error">
            {{ session()->get('error') }}
        </x-adminlte-alert>
    @endif

    @if (session()->has('success'))
        <x-adminlte-alert theme="success" title="Success">
            {{ session()->get('success') }}
        </x-adminlte-alert>
    @endif
    
    <x-adminlte-button
        class="btn mb-3"
        type="button"
        label="Add New User"
        theme="outline-success"
        icon="fas fa-lg fa-plus"
        data-toggle="modal"
        data-target="#add-user"
    />
    
    <x-adminlte-input
        name="search"
        label="Search"
        placeholder="search"
        igroup-size="md"
        wire:model="search"
    >
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="fas fa-search"></i>
            </div>
        </x-slot>
    </x-adminlte-input>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr scope="row">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                            {{--
                                Penamaan Role Bisa Disesuaikan pada tampilan website.
                                Di database role cuma number 1, 2, 3
                                1: Pemilik
                                2: Gudang
                                3: Apoteker
                            --}}
                            @if ($user->role == 1)
                                Pemilik
                            @elseif ($user->role == 2)
                                Gudang
                            @else
                                Apoteker
                            @endif
                        </td>
                        <td>
                            @unless ($user->role === 1)
                                @can(['gudang', 'pemilik'])
                                    <button
                                        class="btn btn-xs btn-default text-primary mx-1"
                                        title="Edit"
                                        data-toggle="modal"
                                        data-target="#edit-user"
                                        wire:click="$emitTo('users.edit-modal', 'setUser', {{ $user->id }})"
                                    >
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </button>
                                    <button
                                        class="btn btn-xs btn-default text-danger mx-1"
                                        title="Delete"
                                        data-toggle="modal"
                                        data-target="#delete-user"
                                        wire:click="$emitTo('users.delete-modal', 'setUserId', {{ $user->id }})"
                                    >
                                        <i class="fa fa-lg fa-fw fa-trash"></i>
                                    </button>
                                @endcan
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No Records found ...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}

    <livewire:users.edit-modal />

    <livewire:users.add-modal />

    <livewire:users.delete-modal />
</div>
