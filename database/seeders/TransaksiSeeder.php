<?php

namespace Database\Seeders;

use App\Models\DetailTransaksi;
use App\Models\Item;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        $tipe = ['masuk', 'keluar'];
        $startDate = Carbon::parse('2021-01-01');
        $endDate = Carbon::parse('2023-08-31');

        while ($startDate->lte($endDate)) {
            $numberOfTransactions = rand(50, 70);
            for ($i = 0; $i < $numberOfTransactions; $i++) {
                $random = rand(0, 1);

                $transaksi = Transaksi::create([
                    'user_id' => 1,
                    'kode_transaksi' => $this->transactionCode($random),
                    'tipe_transaksi' => $tipe[$random],
                    'created_at' => $this->generateRandomDate($startDate, $startDate->copy()->endOfMonth()),
                ]);

                $jumlah_item = rand(1, 5);
                $item_ids = Item::pluck('id')->shuffle()->slice(0, $jumlah_item);

                foreach ($item_ids as $item_id) {
                    $item = Item::find($item_id);
                    $jumlah = rand(1, 10);
                    $harga = $item->harga;
                    $sub_total = $jumlah * $harga;

                    if ($random == 0) {
                        DetailTransaksi::create([
                            'transaksi_id' => $transaksi->id,
                            'item_id' => $item_id,
                            'jumlah' => $jumlah,
                            'harga' => $harga
                        ]);
                    } elseif ($random == 1) {
                        DetailTransaksi::create([
                            'transaksi_id' => $transaksi->id,
                            'item_id' => $item_id,
                            'jumlah' => $jumlah,
                            'harga' => $harga,
                            'sub_total' => $sub_total,
                        ]);
                        $transaksi->increment('total', $sub_total);
                    }
                }
            }
            $startDate->addMonth(); // Pindah ke bulan berikutnya
        }
    }

    public function generateRandomDate($start, $end)
    {
        return Carbon::parse($start)->addDays(rand(0, $end->diffInDays($start)))->format('Y-m-d H:i:s');
    }

    public function transactionCode($tipe = 0)
    {
        $kode = null;
        if ($tipe == 0) {
            $kode = 'TRX-M-' . $this->randomString(10);
        } else if ($tipe == 1) {
            $kode = 'TRX-K-' . $this->randomString(10);
        } else {
            $kode = null;
        }
        return $kode;
    }

    public function randomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $string .= $characters[$randomIndex];
        }
        return $string;
    }
}
