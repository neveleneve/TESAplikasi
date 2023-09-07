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
                <div class="head3">Jl. Gatot Subroto No. 6 - 9 Tanjungpinang </div>
                <div class="head3">Telp. 0771 - 317183 </div>
            </td>
        </tr>
    </table>
    <br>
    <div class="head2" style="text-align: center">{{ $title }}</div>
    <div class="head1" style="text-align: center">Bulan {{ $waktu }}</div>
    <p>Data per {{ date('j F Y') }} Pukul {{ date('H:i:s') }}</p>
    <table class="report report-siswa">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                @if ($tipe == 'keluar' || $tipe == null)
                    <th>Total</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @forelse ($data as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->kode_transaksi }}</td>
                    <td>{{ date('j F Y', strtotime($item->created_at)) }}</td>
                    @if ($tipe == 'keluar' || $tipe == null)
                        <td style="text-align: right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    @endif
                </tr>
                @php
                    $total += $item->total;
                @endphp
            @empty
                <tr>
                    <td colspan="4">
                        <div class="head1">Data Kosong</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if ($tipe == 'keluar' || $tipe == null)
            <tfoot>
                <tr>
                    <td colspan="3">
                        Total
                    </td>
                    <td style="text-align: right">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>
    <table>
        <tbody>

            <tr>
                <td>Tanggal, {{ date('j F Y') }}</td>
            </tr>
            <tr>
                <td>Tertanda,</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>[..............................................]</td>
            </tr>
        </tbody>
    </table>
</body>
