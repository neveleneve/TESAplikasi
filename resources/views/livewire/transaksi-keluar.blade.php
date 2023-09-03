<div class="row justify-content-center mt-3">
    <div class="col-12 col-lg-10">
        @if (session()->has('message'))
            <div class="alert alert-{{ session('color') }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header text-bg-dark">
                <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-light">
                    <i class="fa fa-chevron-left"></i>
                </a>
            </div>
            <form action="{{ route('transaksi.store') }}" method="post">
                @csrf
                <div class="card-body row justify-content-center">
                    <h4 class="text-center fw-bold">Tambah Transaksi Keluar</h4>
                    <br>
                    <div class="col-12 col-lg-10 text-center mb-3">
                        <label for="kode_transaksi" class="fw-bold mb-2">Kode Transaksi</label>
                        <input type="text" name="kode_transaksi" id="kode_transaksi" required readonly
                            class="form-control form-control-sm text-center" wire:model='kode'>
                    </div>
                    <div class="col-12 col-lg-10 text-center">
                        <label for="tipe_transaksi" class="fw-bold mb-2">Tipe Transaksi</label>
                        <input type="text" name="tipe_transaksi" id="tipe_transaksi" required readonly
                            wire:model='tipe.name' class="form-control form-control-sm text-center">
                    </div>
                    <input type="hidden" name="kode_tipe_transaksi" wire:model='tipe.code'>
                    <div class="col-12 col-lg-10 text-center">
                        <hr>
                    </div>
                    <h4 class="text-center fw-bold">Pilih Item</h4>
                    <div class="col-12 col-lg-10 text-center mb-3">
                        <div class="input-group input-group-sm mb-3">
                            <input type="text" class="form-control" placeholder="Pencarian Item..."
                                wire:model='search'>
                            @if ($search != null || $search != '')
                                <span class="input-group-text bg-danger text-light" id="clearText"
                                    style="cursor: pointer;" wire:click='clearText'>
                                    &times;
                                </span>
                            @endif
                        </div>
                        <div class="table-container">
                            <table class="table table-bordered">
                                <thead class="table-dark fw-bold">
                                    <tr>
                                        <td>#</td>
                                        <td>Nama</td>
                                        <td>Stok</td>
                                        <td>Harga</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm text-center"
                                                    min="0" max="{{ $item->stok }}"
                                                    wire:model='selecteditems.{{ $item->id }}' name="selected[]">
                                                <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <h4 class="fw-bold">Data Kosong</h4>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-10 text-center">
                        <p class="fw-bold">Total</p>
                        <p>{{ $this->total() }}</p>
                    </div>

                    <div class="col-12 col-lg-10 text-center d-grid gap-2">
                        <button type="submit" class="btn btn-sm btn-outline-success fw-bold"
                            {{ $search != null || $search != '' ? 'disabled' : null }}>
                            Tambah Transaksi
                        </button>
                    </div>
                    @if ($search != null || $search != '')
                        <p class="my-3 text-danger text-center fw-bold">
                            {{ 'Silahkan kosongkan inputan pencarian untuk melanjutkan!' }}
                        </p>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @push('livewire-style')
        @livewireStyles
    @endpush

    @push('custom-style')
        <style>
            .table-container {
                max-height: 300px;
                overflow-y: auto;
            }
        </style>
    @endpush

    @push('livewire-script')
        @livewireScripts
    @endpush

</div>
