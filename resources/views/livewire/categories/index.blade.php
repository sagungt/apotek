<div>
    <x-adminlte-button
        class="btn mb-3"
        type="button"
        label="Add New Category"
        theme="outline-success"
        icon="fas fa-lg fa-plus"
        data-toggle="modal"
        data-target="#add-category"
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
                    <th scope="col">Nama Kategori</th>
                    <th scope="col" class="text-center">Deskripsi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr scope="row">
                        <td>{{ $category->kategori_id }}</td>
                        <td>{{ $category->nama_kategori }}</td>
                        <td><p class="text-center">{{ $category->deskripsi ?? '-' }}</p></td>
                        <td>
                            <button
                                class="btn btn-xs btn-default text-primary mx-1"
                                title="Edit"
                                data-toggle="modal"
                                data-target="#edit-category"
                                wire:click="$emitTo('categories.edit-modal', 'setCategory', {{ $category->kategori_id }})"
                            >
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <button
                                class="btn btn-xs btn-default text-danger mx-1"
                                title="Delete"
                                data-toggle="modal"
                                data-target="#delete-category"
                                wire:click="$emitTo('categories.delete-modal', 'setCategoryId', {{ $category->kategori_id }})"
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

    {{ $categories->links() }}

    <livewire:categories.edit-modal />

    <livewire:categories.add-modal />

    <livewire:categories.delete-modal />
</div>
