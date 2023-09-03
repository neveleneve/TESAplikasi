<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;

class TransaksiMasuk extends Component
{
    public $search = null;
    public $kode;
    public $tipe = [
        'code' => 'masuk',
        'name' => 'Transaksi Masuk'
    ];
    public $items;
    public $selecteditems;

    public function render()
    {
        if ($this->search == null || $this->search == '') {
            $this->items = Item::get();
        } else {
            $this->items = Item::where('name', 'LIKE', '%' . $this->search . '%')->get();
        }
        return view('livewire.transaksi-masuk');
    }

    public function mount()
    {
        $items = Item::get();
        for ($i = 0; $i < count($items); $i++) {
            $this->selecteditems[$items[$i]->id] = 0;
        }
    }

    public function clearText()
    {
        $this->search = '';
    }
}
