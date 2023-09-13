<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Helpers\HoltWinter;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function item()
    {
        $item = Item::get();
        $title = 'Laporan Daftar Barang Tersedia ' . date('F Y') . '.pdf';
        $pdf = PDF::loadView('pages.laporan.item', [
            'data' => $item,
            'title' => $title,
        ])->setPaper('a4', 'potrait')
            ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);
        return $pdf->stream($title);
    }

    public function transaksiAll(Request $request)
    {
        $title = '';
        $tipe = null;
        $data = [];
        if ($request->has('jenis')) {
            if ($request->jenis == 'all') {
                $title = 'Laporan Daftar Transaksi';
            } else if ($request->jenis == 'masuk') {
                $title = 'Laporan Daftar Transaksi Masuk';
                $tipe = 'masuk';
            } else if ($request->jenis == 'keluar') {
                $title = 'Laporan Daftar Transaksi Keluar';
                $tipe = 'keluar';
            }
        }
        if ($tipe == null) {
            $data = Transaksi::whereMonth('created_at', $request->bulan)
                ->whereYear('created_at', $request->tahun)
                ->orderBy('created_at')
                ->get();
        } else {
            $data = Transaksi::whereMonth('created_at', $request->bulan)
                ->whereYear('created_at', $request->tahun)
                ->where('tipe_transaksi', $tipe)
                ->orderBy('created_at')
                ->get();
        }

        $pdf = PDF::loadView('pages.laporan.transaksi-all', [
            'data' => $data,
            'title' => $title,
            'tipe' => $tipe,
            'waktu' => $this->namaBulan($request->bulan) . ' ' . $request->tahun,
        ])->setPaper('a4', 'potrait')
            ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);
        return $pdf->stream($title);
    }

    public function transaksiOne(Transaksi $transaksi)
    {
        // dd($transaksi);
        $title = 'Invoice Transaksi ' . $transaksi->kode_transaksi;

        $pdf = PDF::loadView('pages.laporan.transaksi-one', [
            'data' => $transaksi,
            'title' => $title,
        ])->setPaper('a4', 'potrait')
            ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);
        return $pdf->stream($title);
    }

    public function forecasting(Request $request)
    {
        $title = 'Laporan Peramalan Barang';
        $data = $this->peramalan();
        $olahData = $this->olahData($data);
        $jumlahdata = count($data);
        $holtwinter = new HoltWinter(0.1, 0.01, 0.02, 12, $olahData);
        $pdf = PDF::loadView('pages.laporan.peramalan', [
            'data' => $data,
            'holtwinter' => $holtwinter->forecast(),
            'count' => $jumlahdata - 1,
            'tahun' => $request->tahun,
            'title' => $title,
        ])->setPaper('a4', 'potrait')
            ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);

        return $pdf->stream($title);
    }

    private function namaBulan($digit)
    {
        $nama = '';
        switch ($digit) {
            case 1:
                $nama = 'Januari';
                break;
            case 2:
                $nama = 'Februari';
                break;
            case 3:
                $nama = 'Maret';
                break;
            case 4:
                $nama = 'April';
                break;
            case 5:
                $nama = 'Mei';
                break;
            case 6:
                $nama = 'Juni';
                break;
            case 7:
                $nama = 'Juli';
                break;
            case 8:
                $nama = 'Agustus';
                break;
            case 9:
                $nama = 'September';
                break;
            case 10:
                $nama = 'Oktober';
                break;
            case 11:
                $nama = 'November';
                break;
            case 12:
                $nama = 'Desember';
                break;
            default:
                $nama = '-';
                break;
        }
        return $nama;
    }

    public function peramalan()
    {
        $quarterlySales = DB::table('transaksis')
            ->join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
            ->select(
                DB::raw('YEAR(transaksis.created_at) as year'),
                DB::raw('MONTH(transaksis.created_at) as month'),
                DB::raw('SUM(detail_transaksis.jumlah) as total_penjualan')
            )
            ->where('tipe_transaksi', 'keluar')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        return $quarterlySales;
    }

    public function olahData($data)
    {
        $fixedData = [];
        foreach ($data as $key => $value) {
            $fixedData[$key] = $value->total_penjualan;
        }
        return $fixedData;
    }
}
