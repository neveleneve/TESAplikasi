<?php

namespace App\Http\Controllers;

use App\Helpers\HoltWinter;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $item = Item::paginate(10);
        return view('pages.item.index', [
            'items' => $item
        ]);
    }

    public function create()
    {
        return view('pages.item.create');
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => ['required'],
            'satuan' => ['required'],
            'harga' => ['required', 'numeric']
        ]);
        if ($validasi->fails()) {
            return redirect(route('daftar-barang.create'))->with([
                'message' => 'Gagal menambah data item. Silakan ulangi!',
                'color' => 'danger',
            ]);
        } else {
            $item = Item::create([
                'name' => ucwords(strtolower($request->name)),
                'satuan' => ucwords(strtolower($request->satuan)),
                'harga' => $request->harga
            ]);
            if ($item) {
                return redirect(route('daftar-barang.index'))->with([
                    'message' => 'Berhasil menambah data item!',
                    'color' => 'success',
                ]);
            } else {
                return redirect(route('daftar-barang.create'))->with([
                    'message' => 'Gagal menambah data item. Silakan ulangi!',
                    'color' => 'danger',
                ]);
            }
        }
        return redirect(route('daftar-barang.index'));
    }

    public function show(Item $daftar_barang)
    {
        $detailtransaksi = $daftar_barang->detailTransaksi()->paginate(10);

        $peramalan = $this->peramalan($daftar_barang->id);
        if (count($peramalan) < 4) {
            $olahData = [];
            $holtwinter = [];
            $forecast = [];
        } else {
            $olahData = $this->olahData($peramalan);
            $holtwinter = new HoltWinter(0.1, 0.01, 0.02, 12, $olahData);
            $forecast = $holtwinter->forecast();
        }

        return view('pages.item.show', [
            'item' => $daftar_barang,
            'detail' => $detailtransaksi,
            'peramalan' => $peramalan,
            'holtwinter' => $forecast,
        ]);
    }

    public function edit(Item $daftarBarang)
    {
        return view('pages.item.edit', [
            'item' => $daftarBarang
        ]);
    }

    public function update(Request $request, Item $daftarBarang)
    {
        $validasi = Validator::make($request->all(), [
            'name' => ['required'],
            'satuan' => ['required'],
            'harga' => ['required', 'numeric'],
        ]);
        if ($validasi->fails()) {
            return redirect(route('daftar-barang.edit', ['daftar_barang' => $daftarBarang->id]))->with([
                'message' => 'Gagal mengubah data item. Silakan ulangi!',
                'color' => 'danger',
            ]);
        } else {
            $daftarBarang->update([
                'name' => $request->name,
                'satuan' => $request->satuan,
                'harga' => $request->harga,
            ]);
            return redirect(route('daftar-barang.edit', ['daftar_barang' => $daftarBarang->id]))->with([
                'message' => 'Berhasil mengubah data item!',
                'color' => 'success',
            ]);
        }
    }

    public function destroy(Item $daftarBarang)
    {
        $daftarBarang->delete();
        return redirect(route('daftar-barang.index'))->with([
            'message' => 'Berhasil menghapus data item : ' . $daftarBarang->name . '!',
            'color' => 'success',
        ]);
    }

    public function peramalan($id)
    {
        $quarterlySales = DB::table('transaksis')
            ->join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
            ->where('detail_transaksis.item_id', '=', $id)
            ->select(
                DB::raw('YEAR(transaksis.created_at) as year'),
                DB::raw('MONTH(transaksis.created_at) as month'),
                DB::raw('SUM(detail_transaksis.jumlah) as total_penjualan')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
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
