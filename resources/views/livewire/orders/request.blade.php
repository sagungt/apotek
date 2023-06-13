<div class="mx-auto">
    <div class="container-sm shadow p-4 rounded">
        <x-adminlte-input
            autocomplete="tanggal"
            name="tanggal"
            label="Tanggal"
            type="date"
            placeholder="Tanggal"
            wire:model.defer="pembelian.tanggal"
            error-key="pembelian.tanggal"
            x-data
            x-on:click="$nextTick(() => $el.showPicker())"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-clock"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-textarea
            autocomplete="keterangan"
            name="keterangan"
            label="Keterangan"
            placeholder="Keterangan"
            rows="4"
            wire:model.defer="pembelian.keterangan"
            error-key="pembelian.keterangan"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-info"></i>
                </div>
            </x-slot>
        </x-adminlte-textarea>

        <hr>

        <x-adminlte-select
            name="obat"
            label="Obat"
            wire:model.defer="orderList.obat_id"
            error-key="orderList.obat_id"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-capsules"></i>
                </div>
            </x-slot>
            <option selected disabled>Select Medicine</option>
            @forelse ($medicines as $medicine)
                <option value="{{ $medicine->obat_id }}">{{ $medicine->nama_obat }}</option>
            @empty
                <option value="">No Medicine Found</option>
            @endforelse
        </x-adminlte-select>

        <x-adminlte-input
            autocomplete="kuantitas"
            name="kuantitas"
            label="Kuantitas"
            type="number"
            placeholder="Kunatitas"
            wire:model.defer="orderList.kuantitas"
            error-key="orderList.kuantitas"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-plus"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-button
            class="btn"
            type="button"
            label="Add to List"
            theme="outline-success"
            icon="fas fa-plus"
        />

        <hr>

        
    </div>
</div>
