<?php

namespace App\Helpers;

use Exception;

class HoltWinter
{
  private $alpha;
  private $beta;
  private $gamma;
  private $L;
  private $series;

  private $levels;
  private $trends;
  private $seasonals;

  function __construct($alpha, $beta, $gamma, $L, $series)
  {
    $this->alpha = $alpha;
    $this->beta = $beta;
    $this->gamma = $gamma;
    $this->L = $L;
    $this->series = $series;

    $this->build_model();
  }

  private function build_model()
  {
    $this->initialize_levels();
    $this->initialize_trends();
    $this->initialize_seasonals();

    for ($i = $this->L; $i < count($this->series); $i++) {
      if ($i == $this->L) {
        $level = $this->series[$i] / $this->seasonals[$i - $this->L];
        $trend = $level - ($this->series[$i - 1] / $this->seasonals[$i - 1]);
        $season = $this->gamma * ($this->series[$i] / $level) + (1 - $this->gamma) * $this->seasonals[$i - $this->L];
      } else {
        $level = $this->alpha * ($this->series[$i] / $this->seasonals[$i - $this->L]) + (1 - $this->alpha) * ($this->levels[$i - 1] + $this->trends[$i - 1]);
        $trend = $this->beta * ($level - $this->levels[$i - 1]) + (1 - $this->beta) * $this->trends[$i - 1];
        $season = $this->gamma * ($this->series[$i] / $level) + (1 - $this->gamma) * $this->seasonals[$i - $this->L];
      }
      $this->levels[$i] = round($level, 2);
      $this->trends[$i] = round($trend, 2);
      $this->seasonals[$i] = round($season, 2);
    }
  }

  private function initialize_levels()
  {
    $this->levels = array();
    for ($i = 0; $i < $this->L; $i++) {
      $this->levels[$i] = null;
    }
  }

  private function initialize_trends()
  {
    $this->trends = array();
    for ($i = 0; $i < $this->L; $i++) {
      $this->trends[$i] = null;
    }
  }

  private function initialize_seasonals()
  {
    $this->seasonals = [];
    $sum = 0;
    for ($i = 0; $i < $this->L; $i++) {
      $sum += $this->series[$i];
    }
    for ($i = 0; $i < $this->L; $i++) {
      $this->seasonals[$i] = round($this->series[$i] / ($sum / $this->L), 2);
    }
  }

  public function forecast()
  {
    $forecast = [];
    for ($i = 0; $i < count($this->series); $i++) {
      if ($i < $this->L) {
        $forecast[$i] = 0;
      } else {
        $forecast[$i] = round($this->levels[$i - 1] + $this->trends[$i - 1] * $this->seasonals[$i  - $this->L], 0);
      }
    }
    return $forecast;
  }
}
