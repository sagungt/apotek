<div>
    <div class="w-100 d-flex align-items-center">
        <x-adminlte-input
            name="start_date"
            type="date"
            label="Start Period"
            wire:model.defer="startDate"
            error-key="startDate"
            class="mr-2"
            x-data
            x-on:click="$nextTick(() => $el.showPicker())"
        >
        </x-adminlte-input>

        <x-adminlte-input
            name="end_date"
            label="End Period"
            type="date"
            wire:model.defer="endDate"
            error-key="endDate"
            class="mr-2"                    
            x-data
            x-on:click="$nextTick(() => $el.showPicker())"
        >
        </x-adminlte-input>

        <x-adminlte-button
            theme="primary"
            label="Submit"
            wire:click="filterDate"
            class="mr-2"
            style="height: fit-content; transform: translateY(8px)"
        />
        <x-adminlte-button
            theme="outline-primary"
            label="Reset"
            wire:click="resetFilterDate"
            class="mr-2"
            style="height: fit-content; transform: translateY(8px)"
        />
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Masuk</th>
                    <th scope="col">Keluar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medicines as $medicine)
                    <tr scope="row">
                        <td>{{ $medicine->nama_obat ?? '-' }}</td>
                        <td>{{ ($medicine->isi_box * $medicine->purchases($startDate, $endDate)->pluck('kuantitas')->sum()) ?? '-' }}</td>
                        <td>{{ $medicine->sales($startDate, $endDate)->pluck('kuantitas')->sum() ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No Select Period First ...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
