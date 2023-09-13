@extends('layouts.app')

@push('custom-style')
    <style>
        .table-container {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        @include('layouts.sidebar')
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center fw-bold">Peramalan Penjualan</h4>
                        <hr>
                        <div class="row">
                            @if (count($data) > 4)
                                <div class="col-12 mb-3">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-dark fw-bold" data-bs-target="#modalCetak"
                                            data-bs-toggle="modal">
                                            Cetak Peramalan
                                        </button>
                                    </div>
                                    <div class="modal fade" id="modalCetak" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cetak Peramalan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('laporan.forecasting') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <select name="tahun" id="tahun" class="form-select" required>
                                                            <option value="">Pilih Tahun</option>
                                                            @for ($i = 0; $i < 3; $i++)
                                                                <option value="{{ date('Y') - $i }}">
                                                                    {{ date('Y') - $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-danger btn-sm fw-bold"
                                                            data-bs-dismiss="modal">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-outline-dark btn-sm fw-bold">
                                                            Cetak
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="table-container">
                                    <table class="table table-bordered text-center">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Tahun</th>
                                                <th>Bulan</th>
                                                <th>Penjualan</th>
                                                <th>Peramalan Stok Barang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data) < 4)
                                                <tr>
                                                    <td colspan="4">
                                                        <h4 class="text-center">
                                                            Peramalan Belum Bisa Dilakukan
                                                        </h4>
                                                    </td>
                                                </tr>
                                            @else
                                                @forelse ($data as $key => $item)
                                                    <tr>
                                                        <td>{{ $item->year }}</td>
                                                        <td>{{ $item->month }}</td>
                                                        <td>{{ $item->total_penjualan }}</td>
                                                        <td>{{ $holtwinter[$count] }}</td>
                                                    </tr>
                                                    @php
                                                        $count--;
                                                    @endphp
                                                @empty
                                                    <tr>
                                                        <td colspan="4">
                                                            <h4 class="text-center">
                                                                Data Kosong
                                                            </h4>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
