<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
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
        return view('pages.item.show', [
            'item' => $daftar_barang
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
}
