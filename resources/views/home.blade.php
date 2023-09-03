@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.sidebar')
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title fw-bold text-center">Dashboard</h3>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-lg">
                                <div class="card border-success mb-3">
                                    <div class="card-body text-success">
                                        <h5 class="card-title">Transaksi Masuk Hari Ini</h5>
                                        <p class="card-text">
                                            {{-- {{ $masuk }} Transaksi --}}
                                        </p>
                                        {{-- <a class="link-success" href="{{ route('masuk.index') }}">Lihat Detail >></a> --}}
                                        <a class="link-success" href="#">Lihat Detail >></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg">
                                <div class="card border-danger mb-3">
                                    <div class="card-body text-danger">
                                        <h5 class="card-title">Transaksi Keluar Hari Ini</h5>
                                        <p class="card-text">
                                            {{-- {{ $keluar }} Transaksi | Rp
                                            {{ number_format($totalkeluar, 0, ',', '.') }} --}}
                                        </p>
                                        <a class="link-danger" href="#">Lihat Detail >></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
