@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.sidebar')
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title fw-bold text-center">Data Transaksi</h3>
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
                                    <button class="btn btn-sm btn-outline-dark fw-bold" data-bs-toggle="modal"
                                        data-bs-target="#modalLaporan">
                                        Tambah Data Transaksi
                                    </button>
                                </div>
                            </div>
                            <div class="modal fade" id="modalLaporan">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Tambah Data Transaksi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('transaksi.create', ['tipe' => 'masuk']) }}"
                                                    class="btn btn-sm btn-outline-success fw-bold">
                                                    Tambah Data Transaksi Masuk
                                                </a>
                                                <a href="{{ route('transaksi.create', ['tipe' => 'keluar']) }}"
                                                    class="btn btn-sm btn-outline-danger fw-bold">
                                                    Tambah Data Transaksi Keluar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg">
                                <div class="d-grid gap-2 mb-3">
                                    <button class="btn btn-sm btn-outline-primary fw-bold" data-bs-toggle="modal"
                                        data-bs-target="#modalTransaksi">
                                        Laporan Data Transaksi
                                    </button>
                                </div>
                            </div>
                            <div class="modal fade" id="modalTransaksi">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Laporan Data Transaksi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('laporan.transaksi.all') }}" method="post">
                                                @csrf
                                                <select name="jenis" id="jenis" class="form-select mb-3" required>
                                                    <option value="">Pilih Jenis Transaksi</option>
                                                    <option value="all">Semua Jenis Transaksi</option>
                                                    <option value="masuk">Transaksi Masuk</option>
                                                    <option value="keluar">Transaksi Keluar</option>
                                                </select>
                                                <select name="bulan" id="bulan" class="form-select mb-3" required>
                                                    <option value="">Pilih Bulan Transaksi</option>
                                                    <option value="1">Januari</option>
                                                    <option value="2">Februari</option>
                                                    <option value="3">Maret</option>
                                                    <option value="4">April</option>
                                                    <option value="5">Mei</option>
                                                    <option value="6">Juni</option>
                                                    <option value="7">Juli</option>
                                                    <option value="8">Agustus</option>
                                                    <option value="9">September</option>
                                                    <option value="10">Oktober</option>
                                                    <option value="11">November</option>
                                                    <option value="12">Desember</option>
                                                </select>
                                                <select name="tahun" id="tahun" class="form-select mb-3" required>
                                                    <option value="">Pilih Tahun Transaksi</option>
                                                    @for ($i = 4; $i >= 0; $i--)
                                                        <option value="{{ date('Y') - $i }}">{{ date('Y') - $i }}</option>
                                                    @endfor
                                                </select>
                                                <div class="d-grid">
                                                    <button type="submit"
                                                        class="btn btn-outline-dark fw-bold">Cetak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center text-nowrap">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Transaksi</th>
                                        <th>Tipe Transaksi</th>
                                        <th>Total Transaksi</th>
                                        <th>Tanggal Transaksi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transaksi as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->kode_transaksi }}</td>
                                            <td>{{ ucwords($item->tipe_transaksi) }}</td>
                                            <td>
                                                {{ $item->total != 0 ? 'Rp ' . number_format($item->total, 0, ',', '.') : '-' }}
                                            </td>
                                            <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                            <td>
                                                <a href="{{ route('transaksi.show', ['transaksi' => $item->id]) }}"
                                                    class="btn btn-sm btn-outline-dark">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('laporan.transaksi.one', ['transaksi' => $item->id]) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                            </td>
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
        <div class="row justify-content-center mt-3">
            {{ $transaksi->links('layouts.paginate') }}
        </div>
    </div>
@endsection
