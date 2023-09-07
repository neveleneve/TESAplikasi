@extends('layouts.app')

@push('livewire-style')
    @livewireStyles
@endpush

@push('livewire-script')
    @livewireScripts
@endpush

@section('content')
    <div class="container">
        @include('layouts.sidebar')
        @livewire('transaksi')
    </div>
@endsection
