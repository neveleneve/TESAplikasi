<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
