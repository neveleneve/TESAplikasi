@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.sidebar')
        @livewire('transaksi-masuk', ['kode' => $kode])
    </div>
@endsection
