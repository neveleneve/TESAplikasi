<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'item_id',
        'jumlah',
        'harga',
        'sub_total',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
