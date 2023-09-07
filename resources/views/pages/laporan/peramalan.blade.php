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
    <div class="head2" style="text-align: center">Laporan Peramalan Barang</div>
    <div class="head1" style="text-align: center">Tahun {{ $tahun }}</div>
    <p>Data per {{ date('j F Y') }} Pukul {{ date('H:i:s') }}</p>

    <table class="report report-siswa">
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Kuartal Ke-</th>
                <th>Penjualan</th>
                <th>Peramalan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                @if ($tahun == $item->year)
                    <tr>
                        <td>{{ $item->year }}</td>
                        <td>{{ $item->quarter }}</td>
                        <td>{{ $item->total_penjualan }}</td>
                        <td>{{ $holtwinter[$count] }}</td>
                    </tr>
                @endif
                @php
                    $count--;
                @endphp
            @endforeach
        </tbody>
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
