<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'satuan',
        'harga',
        'stok',
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class)->orderBy('created_at', 'desc');
    }

    public function getTotalPenjualanPerQuarter()
    {
        return $this->detailTransaksi()
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->selectRaw('YEAR(transaksis.created_at) as year, QUARTER(transaksis.created_at) as quarter, SUM(detail_transaksis.jumlah) as total_penjualan')
            ->groupBy('year', 'quarter')
            ->orderByRaw('YEAR(transaksis.created_at) DESC, year ASC, quarter ASC')
            ->get();
    }
}
