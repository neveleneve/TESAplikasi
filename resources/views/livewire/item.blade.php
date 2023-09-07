<div class="row justify-content-center mt-3">
    <div class="col-12 col-lg-10">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title fw-bold text-center">Data Item</h3>
                <hr>
                @if (session()->has('message'))
                    <div class="alert alert-{{ session('color') }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12 col-lg">
                        <div class="d-grid gap-2 mb-3">
                            <a href="{{ route('daftar-barang.create') }}" class="btn btn-sm btn-outline-dark fw-bold">
                                Tambah Data Item
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg">
                        <div class="d-grid gap-2 mb-3">
                            <a href="{{ route('laporan.item') }}" class="btn btn-sm btn-outline-primary fw-bold">
                                Laporan Data Item
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <input type="text" wire:model='search' class="form-control form-control-sm"
                            placeholder="Pencarian...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center text-nowrap">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ ucwords(strtolower($item->satuan)) }}</td>
                                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>
                                                <a href="{{ route('daftar-barang.show', ['daftar_barang' => $item->id]) }}"
                                                    class="btn btn-sm btn-outline-dark">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('daftar-barang.edit', ['daftar_barang' => $item->id]) }}"
                                                    class="btn btn-sm btn-outline-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <h6 class="fw-bold text-center h4">Data Kosong</h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        {{ $items->links('layouts.paginate-livewire') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
