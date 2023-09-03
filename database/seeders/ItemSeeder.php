<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Kabel Listrik', 'satuan' => 'meter', 'harga' => 5000],
            ['nama' => 'Stop Kontak', 'satuan' => 'buah', 'harga' => 15000],
            ['nama' => 'Lampu LED', 'satuan' => 'buah', 'harga' => 10000],
            ['nama' => 'Saklar', 'satuan' => 'buah', 'harga' => 7000],
            ['nama' => 'Kipas Angin', 'satuan' => 'buah', 'harga' => 25000],
            ['nama' => 'Steker', 'satuan' => 'buah', 'harga' => 8000],
            ['nama' => 'Baterai AA', 'satuan' => 'buah', 'harga' => 3000],
            ['nama' => 'Baterai AAA', 'satuan' => 'buah', 'harga' => 2500],
            ['nama' => 'Transformator', 'satuan' => 'buah', 'harga' => 12000],
            ['nama' => 'Kabel HDMI', 'satuan' => 'meter', 'harga' => 7000],
            ['nama' => 'Kabel USB', 'satuan' => 'meter', 'harga' => 4000],
            ['nama' => 'Baut Listrik', 'satuan' => 'buah', 'harga' => 2000],
            ['nama' => 'Tape Listrik', 'satuan' => 'roll', 'harga' => 10000],
            ['nama' => 'Konektor RJ45', 'satuan' => 'buah', 'harga' => 6000],
            ['nama' => 'Relay', 'satuan' => 'buah', 'harga' => 9000],
            ['nama' => 'Fuse', 'satuan' => 'buah', 'harga' => 500],
            ['nama' => 'Multimeter', 'satuan' => 'buah', 'harga' => 35000],
            ['nama' => 'Switch Ethernet', 'satuan' => 'buah', 'harga' => 10000],
            ['nama' => 'Kipas Pendingin', 'satuan' => 'buah', 'harga' => 18000],
            ['nama' => 'Termometer Listrik', 'satuan' => 'buah', 'harga' => 8000]
        ];

        for ($i = 0; $i < count($data); $i++) {
            Item::create([
                'name' => $data[$i]['nama'],
                'satuan' => $data[$i]['satuan'],
                'harga' => $data[$i]['harga'],
                'stok' => 1000,
            ]);
        }
    }
}
