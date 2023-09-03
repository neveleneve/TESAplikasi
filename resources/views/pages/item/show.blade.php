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
                                <label for="harga" class="fw-bold mb-2">Satuan</label>
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
            <div class="col-12 col-lg-10">
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
                                @forelse ($item->detailTransaksi as $items)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
