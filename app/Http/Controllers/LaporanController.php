<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Helpers\HoltWinter;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function item()
    {
        // 
    }

    public function transaksiAll(Request $request)
    {
        // 
    }

    public function transaksiOne(Transaksi $transaksi)
    {
        // 
    }

    public function forecasting()
    {
        // Data historis (contoh data sederhana)
        $data = ['27', '12', '43', '12', '12', '16', '19', '43', '12', '40', '100', '500'];

        $hitungA = $this->holt_winters($data, 6, 0.1, 0.02, 0.01);
        $hitungB = new HoltWinter(0.1, 0.01, 0.02, 6, $data);

        dd([$hitungA, $hitungB]);
    }

    public function holt_winters($data, $season_length = 7, $alpha = 0.2, $beta = 0.01, $gamma = 0.01, $dev_gamma = 0.1)
    {
        // Calculate an initial trend level
        $trend1 = 0;
        for ($i = 0; $i < $season_length; $i++) {
            $trend1 += $data[$i];
        }
        $trend1 /= $season_length;
        echo $season_length;
        $trend2 = 0;
        for ($i = $season_length; $i < 2 * $season_length; $i++) {
            $trend2 += $data[$i];
        }
        $trend2 /= $season_length;

        $initial_trend = ($trend2 - $trend1) / $season_length;

        // Take the first value as the initial level
        $initial_level = $data[0];

        // Build index
        $index = array();
        foreach ($data as $key => $val) {
            $index[$key] = $val / ($initial_level + ($key + 1) * $initial_trend);
        }

        // Build season buffer
        $season = array_fill(0, count($data), 0);
        for ($i = 0; $i < $season_length; $i++) {
            $season[$i] = ($index[$i] + $index[$i + $season_length]) / 2;
        }

        // Normalise season
        $season_factor = $season_length / array_sum($season);
        foreach ($season as $key => $val) {
            $season[$key] *= $season_factor;
        }


        $holt_winters = array();
        $deviations = array();
        $alpha_level = $initial_level;
        $beta_trend = $initial_trend;
        foreach ($data as $key => $value) {
            $temp_level = $alpha_level;
            $temp_trend = $beta_trend;

            $alpha_level = $alpha * $value / $season[$key] + (1.0 - $alpha) * ($temp_level + $temp_trend);
            $beta_trend = $beta * ($alpha_level - $temp_level) + (1.0 - $beta) * $temp_trend;

            $season[$key + $season_length] = $gamma * $value / $alpha_level + (1.0 - $gamma) * $season[$key];

            $holt_winters[$key] = ($alpha_level + $beta_trend * ($key + 1)) * $season[$key];
            $deviations[$key] = $dev_gamma * abs($value - $holt_winters[$key]) + (1 - $dev_gamma)
                * (isset($deviations[$key - $season_length]) ? $deviations[$key - $season_length] : 0);
        }
        return array($holt_winters, $deviations);
    }
}
