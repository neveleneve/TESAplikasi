<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $masuk = Transaksi::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->where('tipe_transaksi', 'masuk')
            ->count();
        $keluar = Transaksi::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->where('tipe_transaksi', 'keluar')
            ->count();
        // dd([$masuk,  $keluar]);

        return view('home', [
            'keluar' => $keluar,
            'masuk' => $masuk,
        ]);
    }
}
