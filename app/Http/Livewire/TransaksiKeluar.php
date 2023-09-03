<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;

class TransaksiKeluar extends Component
{
    public $search = null;
    public $kode;
    public $tipe = [
        'code' => 'keluar',
        'name' => 'Transaksi Keluar'
    ];
    public $items;
    public $selecteditems;
    public $hargadata;
    public $iddata;

    public function render()
    {
        if ($this->search == null || $this->search == '') {
            $this->items = Item::where('stok', '>', 0)->get();
        } else {
            $this->items = Item::where('stok', '>', 0)->where('name', 'LIKE', '%' . $this->search . '%')->get();
        }
        return view('livewire.transaksi-keluar');
    }

    public function mount()
    {
        $items = Item::where('stok', '>', 0)->get();
        for ($i = 0; $i < count($items); $i++) {
            $this->selecteditems[$items[$i]->id] = 0;
            $this->iddata[$i] = $items[$i]->id;
            $this->hargadata[$i] = $items[$i]->harga;
        }
    }

    public function clearText()
    {
        $this->search = '';
    }

    public function total()
    {
        $total = 0;
        $return = null;
        for ($i = 0; $i < count($this->selecteditems); $i++) {
            $total += $this->selecteditems[$this->iddata[$i]] * $this->hargadata[$i];
        }
        if ($total > 0) {
            $return = 'Rp ' . number_format($total, 0, ',', '.');
        } else {
            $return = '-';
            # code...
        }
        return $return;
    }
}
