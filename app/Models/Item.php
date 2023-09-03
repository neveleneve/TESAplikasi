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
        return $this->hasMany(DetailTransaksi::class)->orderBy();
    }
}
