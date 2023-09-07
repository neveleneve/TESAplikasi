<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        table {
            width: 100%;
        }

        .half {
            width: 50%;
        }

        .report {
            font-size: 15px;
        }

        .report-header {
            border-bottom: 2px solid black;
            width: 100%;
        }

        .report-header td {
            text-align: center;
            /*border: 1px solid green;*/
        }

        .report-rincian td {
            height: 26px;
            /*line-height: 1px;*/
            vertical-align: top;
            text-align: justify;
        }

        .report-siswa {
            border-collapse: collapse;
        }

        .report-siswa td,
        .report-siswa th {
            text-align: center;
            /* height: 30px; */
            padding: 5px 10px;
            border: 1px solid #333;
        }


        .head1 {
            font-size: 20px;
            letter-spacing: 2px;
        }

        .head2 {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 3px;
        }

        .head3 {
            font-size: 12px;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <table class="report report-header">
        <tr>
            <td style="width: 15%;">
                <img src="{{ asset('images/llogo.png') }}" style="width: 100px;">
            </td>
            <td style="width: 85%;">
                <div class="head2">Toko Bangun Jaya</div>
                <div class="head3">Jl. Tambak No. 21 Kota Tanjungpinang Kel. Kamboja Kec. Tanjungpinang Barat</div>
            </td>
        </tr>
    </table>
    <br>
    <div class="head2" style="text-align: center">Invoice Transaksi</div>
    <table class="report report-rincian half">
        <tr>
            <td>Kode Transaksi</td>
            <td>: {{ $data->kode_transaksi }} </td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ date('d F Y H:i:s', strtotime($data->created_at)) }}</td>
        </tr>
        @if ($data->tipe_transaksi == 'keluar')
            <tr>
                <td>Total Belanja</td>
                <td>: Rp {{ number_format($data->total, 0, ',', '.') }}</td>
            </tr>
        @endif
    </table>
    <table class="report report-siswa">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Item</th>
                @if ($data->tipe_transaksi == 'keluar')
                    <th>Harga</th>
                @endif
                <th>Jumlah</th>
                @if ($data->tipe_transaksi == 'keluar')
                    <th>Subtotal</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($data->detailTransaksi as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->item->name }}</td>
                    @if ($data->tipe_transaksi == 'keluar')
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    @endif
                    <td>{{ $item->jumlah }}</td>
                    @if ($data->tipe_transaksi == 'keluar')
                        <td>Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <div class="head1">Data Kosong</div>

                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
