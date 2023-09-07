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
        // dd($item);
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
}
