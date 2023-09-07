<?php

namespace App\Http\Livewire;

use App\Models\Item as ModelsItem;
use Illuminate\Pagination\Paginator;
use Livewire\Component;

class Item extends Component
{
    public $search;
    public $currentPage;

    public function render()
    {
        if ($this->search == null || $this->search == '') {
            $item = ModelsItem::paginate(10);
        } else {
            $item = ModelsItem::where('name', 'LIKE', '%' . $this->search . '%')
                ->paginate(10);
        }
        return view('livewire.item', [
            'items' => $item
        ]);
        return view('livewire.item');
    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }
}
