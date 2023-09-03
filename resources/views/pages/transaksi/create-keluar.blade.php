@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.sidebar')
        @livewire('transaksi-keluar', ['kode' => $kode])
    </div>
@endsection
