<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Item;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transaksi = Transaksi::orderBy('created_at', 'desc')->paginate(10);
        return view('pages.transaksi.index', [
            'transaksi' => $transaksi
        ]);
    }

    public function create(Request $request)
    {
        if ($request->has('tipe')) {
            if ($request->tipe == 'masuk') {
                $kode = $this->transactionCode(0);
                return view('pages.transaksi.create-masuk', [
                    'kode' => $kode
                ]);
            } else if ($request->tipe == 'keluar') {
                $kode = $this->transactionCode(1);
                return view('pages.transaksi.create-keluar', [
                    'kode' => $kode
                ]);
            } else {
                return redirect(route('transaksi.index'));
            }
        } else {
            return redirect(route('transaksi.index'));
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->has('kode_tipe_transaksi')) {
            $validasi = Validator::make($request->all(), [
                'kode_transaksi' => ['required'],
                'tipe_transaksi' => ['required'],
                'kode_tipe_transaksi' => ['required'],
                'selected' => ['required'],
                'id_item' => ['required'],
            ]);
            if ($validasi->fails()) {
                if ($request->kode_tipe_transaksi == 'masuk') {
                    return redirect(route('transaksi.create', ['tipe' => 'masuk']))->with([]);
                } else if ($request->kode_tipe_transaksi == 'keluar') {
                    return redirect(route('transaksi.create', ['tipe' => 'keluar']))->with([]);
                } else {
                    return redirect(route('transaksi.index'));
                }
            } else {
                $total = 0;
                for ($i = 0; $i < count($request->selected); $i++) {
                    $total += $request->selected[$i];
                }
                if ($total == 0) {
                    return redirect(route('masuk.create'))->with([
                        'message' => 'Gagal menambahkan data transaksi. Silakan ulangi!',
                        'color' => 'danger',
                    ]);
                }
                $transaksi = Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_transaksi' => $request->kode_transaksi,
                    'tipe_transaksi' => $request->kode_tipe_transaksi,
                ]);
                $totalbelanja = 0;
                for ($i = 0; $i < count($request->selected); $i++) {
                    $item = Item::find($request->id_item[$i]);
                    if ($request->selected[$i] > 0) {
                        $detail_trx = DetailTransaksi::create([
                            'transaksi_id' => $transaksi->id,
                            'item_id' => $request->id_item[$i],
                            'jumlah' => $request->selected[$i],
                            'harga' => $item->harga,
                        ]);
                        $totalbelanja += $request->selected[$i] * $item->harga;
                        if ($detail_trx) {
                            if ($request->kode_tipe_transaksi == 'masuk') {
                                $item->increment('stok', $request->selected[$i]);
                            } else if ($request->kode_tipe_transaksi == 'keluar') {
                                $transaksi->increment('total', $totalbelanja);
                                $item->decrement('stok', $request->selected[$i]);
                            }
                        }
                    }
                }
                return redirect(route('transaksi.index'))->with([
                    'message' => 'Berhasil menambahkan data transaksi masuk!',
                    'color' => 'success',
                ]);
            }
        } else {
            return redirect(route('transaksi.index'));
        }
    }

    public function show(Transaksi $transaksi)
    {
        //
    }

    public function edit(Transaksi $transaksi)
    {
        //
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
