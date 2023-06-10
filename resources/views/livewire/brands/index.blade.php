<div>
    <x-adminlte-button
        class="btn mb-3"
        type="button"
        label="Add New Brand"
        theme="outline-success"
        icon="fas fa-lg fa-plus"
        data-toggle="modal"
        data-target="#add-brand"
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
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($brands as $brand)
                    <tr scope="row">
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            <button
                                class="btn btn-xs btn-default text-primary mx-1"
                                title="Edit"
                                data-toggle="modal"
                                data-target="#edit-brand"
                                wire:click="$emitTo('brands.edit-modal', 'setBrand', {{ $brand->id }})"
                            >
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <button
                                class="btn btn-xs btn-default text-danger mx-1"
                                title="Delete"
                                data-toggle="modal"
                                data-target="#delete-brand"
                                wire:click="$emitTo('brands.delete-modal', 'setBrandId', {{ $brand->id }})"
                            >
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No Records found ...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $brands->links() }}

    <livewire:brands.edit-modal />

    <livewire:brands.add-modal />

    <livewire:brands.delete-modal />
</div>
