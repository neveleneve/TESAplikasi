<?php

namespace App\Http\Controllers;

use App\Helpers\HoltWinter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeramalanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = $this->peramalan();
        $olahData = $this->olahData($data);
        $jumlahdata = count($data);
        $holtwinter = new HoltWinter(0.1, 0.01, 0.02, 4, $olahData);
        return view('pages.peramalan.index', [
            'peramalan' => $data,
            'holtwinter' => $holtwinter->forecast(),
            'count' => $jumlahdata - 1,
        ]);
    }

    public function peramalan()
    {
        $quarterlySales = DB::table('transaksis')
            ->join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
            ->select(
                DB::raw('YEAR(transaksis.created_at) as year'),
                DB::raw('QUARTER(transaksis.created_at) as quarter'),
                DB::raw('SUM(detail_transaksis.jumlah) as total_penjualan')
            )
            ->where('tipe_transaksi', 'keluar')
            ->groupBy('year', 'quarter')
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
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
