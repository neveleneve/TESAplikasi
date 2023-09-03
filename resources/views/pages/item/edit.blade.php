@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.sidebar')
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header text-bg-dark">
                        <a href="{{ route('daftar-barang.index') }}" class="btn btn-sm btn-outline-light">
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
                        <h4 class="fw-bold text-center">Edit Data Item</h4>
                        <hr>
                        <form action="{{ route('daftar-barang.update', ['daftar_barang' => $item->id]) }}" method="post"
                            class="row justify-content-center">
                            @csrf
                            @method('put')
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <label for="name" class="fw-bold mb-2">Nama Item</label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm"
                                    placeholder="Nama Item" value="{{ $item->name }}" required>
                            </div>
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <label for="satuan" class="fw-bold mb-2">Nama Satuan Item</label>
                                <input type="text" name="satuan" id="satuan" class="form-control form-control-sm"
                                    placeholder="Nama Satuan Item" value="{{ $item->satuan }}" required>
                            </div>
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <label for="harga" class="fw-bold mb-2">Harga Item</label>
                                <input type="number" name="harga" id="harga" class="form-control form-control-sm"
                                    placeholder="Harga Item" value="{{ $item->harga }}" required>
                            </div>
                            <div class="col-12 col-lg-10 text-center mb-3">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-sm btn-outline-dark fw-bold" type="submit">
                                        Edit Item
                                    </button>
                                </div>
                            </div>
                        </form>
                        @if ($item->stok == 0)
                            <form action="{{ route('daftar-barang.destroy', ['daftar_barang' => $item->id]) }}"
                                method="post" class="row justify-content-center">
                                @csrf
                                @method('delete')
                                <div class="col-12 col-lg-10 text-center mb-3">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-sm btn-outline-danger fw-bold" type="submit"
                                            onclick="return confirm('Hapus Data Item?')">
                                            Hapus Data Item
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
