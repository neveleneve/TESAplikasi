@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.sidebar')
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-lg-10">
                <div class="card mb-3">
                    <div class="card-header text-bg-dark">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-light">
                            <i class="fa fa-chevron-left"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <h4 class="fw-bold text-center">Data Transaksi</h4>
                        <hr>
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <label for="stok" class="fw-bold mb-2">Nama Kasir</label>
                                <p>
                                    {{ $transaksi->user->name }}
                                </p>
                            </div>
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <label for="name" class="fw-bold mb-2">Kode Transaksi</label>
                                <p>
                                    {{ $transaksi->kode_transaksi }}
                                </p>
                            </div>
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <label for="satuan" class="fw-bold mb-2">Tipe Transaksi</label>
                                <p>
                                    {{ ucwords($transaksi->tipe_transaksi) }}
                                </p>
                            </div>
                            @if ($transaksi->tipe_transaksi == 'keluar')
                                <div class="col-12 col-lg-10 text-center mb-3">
                                    <label for="harga" class="fw-bold mb-2">Total</label>
                                    <p>
                                        Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="fw-bold text-center">Detail Transaksi</h4>
                        <hr>
                        <table class="table text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    @if ($transaksi->tipe_transaksi == 'keluar')
                                        <th>Subtotal</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksi->detailTransaksi as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->item->name }}</td>
                                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        @if ($transaksi->tipe_transaksi == 'keluar')
                                            <td>Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                                        @endif
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
