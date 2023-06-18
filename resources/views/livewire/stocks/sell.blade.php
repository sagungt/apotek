<div>
    {{$errors}}
    <div class="my-2 container">
        <div class="bg-white p-4 border">
            <x-adminlte-select
                name="tipe"
                label="Resep / Non Resep"
                wire:model="sell.tipe"
                error-key="sell.tipe"
            >
                <option selected>Select Medicine</option>
                <option value="Resep">Resep</option>
                <option value="Non Resep">Non Resep</option>
            </x-adminlte-select>

            @if (isset($sell['tipe']) && $sell['tipe'] === 'Resep')
                <x-adminlte-input
                    name="nama_dokter"
                    label="Nama Dokter"
                    placeholder="Nama Dokter"
                    wire:model="sell.nama_dokter"
                    error-key="sell.nama_dokter"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user-md"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input
                    name="nama_pelanggan"
                    label="Nama Pelanggan"
                    placeholder="Nama Pelanggan"
                    wire:model="sell.nama_pelanggan"
                    error-key="sell.nama_pelanggan"
                >
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user-injured"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            @endif

            <x-adminlte-input
                name="no_faktur"
                label="No Faktur"
                placeholder="No Faktur"
                wire:model="sell.no_faktur"
                error-key="sell.no_faktur"
            >
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-receipt"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input
                autocomplete="tanggal"
                name="tanggal"
                label="Tanggal"
                type="date"
                placeholder="Tanggal"
                wire:model.defer="sell.tanggal"
                error-key="sell.tanggal"
                x-data
                x-on:click="$nextTick(() => $el.showPicker())"
            >
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-clock"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Obat</th>
                            <th scope="col">No Batch</th>
                            <th scope="col">Kuantitas</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderList as $index => $order)
                            <tr scope="row">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order['nama'] }}</td>
                                <td>{{ $order['no_batch'] }}</td>
                                <td>{{ $order['kuantitas'] }}</td>
                                <td>Rp. {{ number_format($order['total']) }}</td>
                                <td>
                                    <button
                                        class="btn btn-xs btn-default text-danger mx-1"
                                        title="Delete"
                                        wire:click="deleteOrder({{ $index }})"
                                    >
                                        <i class="fa fa-lg fa-fw fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Records found ...</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="5" class="text-center"><span class="fw-bolder fs-4">Grand Total</span></td>
                            <td>Rp. {{ number_format($grandTotal) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <x-adminlte-button
                :disabled="sizeof($orderList) === 0"
                class="btn mb-3 w-100"
                type="button"
                label="Confirm"
                theme="success"
                icon="fas fa-lg fa-check"
                wire:click="submit"
            />

            
            <x-adminlte-select
                name="order_obat_id"
                id="order_obat_id"
                class="border"
                label="Obat"
                wire:model.defer="order.obat_id"
                error-key="order.obat_id"
            >
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-capsules"></i>
                    </div>
                </x-slot>
                <option>Pilih Obat</option>
                @forelse ($stocks as $stock)
                    <option value="{{ $stock->id }}">{{ $stock->medicine->nama_obat }} ({{ $stock->stok }}) | Rp. {{ number_format($stock->medicine->harga + ($stock->medicine->harga * 0.1)) }}</option>
                @empty
                    <option disabled>Tidak ada obat</option>
                @endforelse
            </x-adminlte-select>

            <x-adminlte-input
                name="kuantitas"
                label="kuantitas"
                type="number"
                placeholder="Kuantitas"
                wire:model.defer="order.kuantitas"
                error-key="order.kuantitas"
            >
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-plus"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-button
                class="btn mb-3"
                type="button"
                label="Add"
                theme="success"
                icon="fas fa-plus"
                wire:click="addToList"
            />

            <hr />

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
        </div>

        <div class="p-4">
            @if (session()->has('error'))
                <x-adminlte-alert theme="danger" title="Error">
                    {{ session()->get('error') }}
                </x-adminlte-alert>
            @endif
            <div class="row row-cols-3">
                @forelse ($stocks as $index => $stock)
                    <div class="card">
                        <div class="card-header">
                            {{ $stock->medicine->category->nama_kategori }}
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-4">{{ $stock->medicine->nama_obat }}</h4>
                                <span>Stock: {{ $stock->stok }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="w-25 fw-bold">Satuan</span>
                                <span class="w-75">{{ $stock->medicine->satuan }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="w-25 fw-bold">Jenis</span>
                                <span class="w-75">{{ $stock->medicine->jenis }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="w-25 fw-bold">Harga</span>
                                <span class="w-75">Rp. {{ number_format($stock->medicine->harga + ($stock->medicine->harga * 0.1)) }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="w-25 fw-bold">Merek</span>
                                <span class="w-75">{{ $stock->medicine->brand->nama_merek }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="w-25 fw-bold">No Exp</span>
                                <span class="w-75">{{ Carbon\Carbon::parse($stock->no_exp)->format('d F Y') }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="w-25 fw-bold">No Batch</span>
                                <span class="w-75">{{ $stock->no_batch }}</span>
                            </div>
                            <div class="d-flex mt-4">
                                <x-adminlte-input
                                    type="number"
                                    class="flex-fill w-100"
                                    name="qty"
                                    placeholder="Kuantitas"
                                    wire:model="quantities.{{ $index }}"
                                    error-key="quantities.{{ $index }}"
                                />
                                <x-adminlte-button
                                    class="btn flex-fill w-100"
                                    style="height: fit-content"
                                    type="button"
                                    label="Add"
                                    theme="primary"
                                    icon="fas fa-plus"
                                    wire:click="addOne({{ $stock->id }}, {{ $index }})"
                                />
                            </div>
                        </div>
                        <div class="card-footer text-body-secondary">
                            {{ Carbon\Carbon::parse($stock->no_exp)->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <h4>No Stock</h4>
                @endforelse
            </div>
        </div>
    </div>

</div>
