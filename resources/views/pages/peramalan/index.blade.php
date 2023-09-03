@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.sidebar')
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center fw-bold">Peramalan Penjualan</h4>
                        <hr>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Kuartal Ke-</th>
                                    <th>Penjualan</th>
                                    <th>Peramalan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peramalan as $key => $item)
                                    <tr>
                                        <td>{{ $item->year }}</td>
                                        <td>{{ $item->quarter }}</td>
                                        <td>{{ $item->total_penjualan }}</td>
                                        <td>{{ $holtwinter[$key] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
