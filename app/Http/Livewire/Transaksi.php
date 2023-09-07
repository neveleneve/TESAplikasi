<?php

namespace App\Http\Livewire;

use App\Models\Transaksi as ModelsTransaksi;
use Illuminate\Pagination\Paginator;
use Livewire\Component;

class Transaksi extends Component
{
    public $search;
    public $currentPage;

    public function render()
    {
        if ($this->search == null || $this->search == '') {
            $transaksi = ModelsTransaksi::orderBy('created_at', 'desc')->paginate(10);
        } else {
            $transaksi = ModelsTransaksi::where('kode_transaksi', 'LIKE', '%' . $this->search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('livewire.transaksi', [
            'transaksi' => $transaksi
        ]);
    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }
}
