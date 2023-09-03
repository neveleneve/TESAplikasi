@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.sidebar')
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-lg-10 mb-3">
                <div class="card">
                    <div class="card-header text-bg-dark">
                        <a href="{{ route('daftar-barang.index') }}" class="btn btn-outline-light">
                            <i class="fa fa-chevron-left"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-{{ session('color') }} alert-dismissible fade show" role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row justify-content-center">
                            <h4 class="fw-bold text-center">Data Item</h4>
                            <hr>
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <label for="name" class="fw-bold mb-2">Nama</label>
                                <p>
                                    {{ $item->name }}
                                </p>
                            </div>
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <label for="satuan" class="fw-bold mb-2">Satuan</label>
                                <p>
                                    {{ $item->satuan }}
                                </p>
                            </div>
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <label for="harga" class="fw-bold mb-2">Harga</label>
                                <p>
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <label for="stok" class="fw-bold mb-2">Stok Item</label>
                                <p>
                                    {{ $item->stok }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-10 mb-3">
                <div class="card">
                    <div class="card-header text-bg-dark text-center">
                        <span class="fw-bold h4">
                            Histori Transaksi
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Kode Transaksi</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($detail as $items)
                                    <tr>
                                        <td>{{ ($detail->currentPage() - 1) * $detail->perPage() + $loop->index + 1 }}</td>
                                        <td>{{ $items->transaksi->kode_transaksi }}</td>
                                        <td>Transaksi {{ ucwords($items->transaksi->tipe_transaksi) }}</td>
                                        <td>{{ $items->jumlah }}</td>
                                        <td>{{ date('d F Y', strtotime($items->transaksi->created_at)) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <h6 class="fw-bold text-center h4">Data Kosong</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-12">
                                {{ $detail->links('layouts.paginate') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header text-bg-dark text-center">
                        <span class="fw-bold h4">
                            Peramalan
                        </span>
                    </div>
                    <div class="card-body">
                        <span>Alpha : 0,1</span>
                        <span>Beta : 0,01</span>
                        <span>Gamma : 0,02</span>
                        <div class="table-container">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tahun</th>
                                        <th>Kuartal Ke-</th>
                                        <th>Jumlah</th>
                                        <th>Peramalan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($peramalan as $key => $items)
                                        <tr>
                                            <td>{{ $items->year }}</td>
                                            <td>{{ $items->quarter }}</td>
                                            <td>{{ $items->total_penjualan }}</td>
                                            <td>{{ $holtwinter[$key] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <h6 class="fw-bold text-center h4">Data Kosong</h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-style')
    <style>
        .table-container {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
@endpush
