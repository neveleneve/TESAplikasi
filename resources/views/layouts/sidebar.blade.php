<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('dashboard*') ? ' active fw-bold disabled' : ' text-dark' }}"
                    href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('daftar-barang*') ? ' active fw-bold disabled' : ' text-dark' }}"
                    href="{{ route('daftar-barang.index') }}">Item</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('transaksi*') ? ' active fw-bold disabled' : ' text-dark' }}"
                    href="{{ route('transaksi.index') }}">Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('peramalan*') ? ' active fw-bold disabled' : ' text-dark' }}"
                    href="{{ route('peramalan.index') }}">Peramalan</a>
            </li>
        </ul>
    </div>
</div>
