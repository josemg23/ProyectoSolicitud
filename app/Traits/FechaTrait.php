<?php

namespace App\Traits;

use Carbon\Carbon;

trait FechaTrait
{

    private $format = 'Y-m-d';

    public function inicioMes()
    {
        $s = Carbon::now()->startOfMonth();
        return $s->format($this->format);
    }

    public function finalMes()
    {
        $e = Carbon::now()->endOfMonth();
        return  $e->format($this->format);
    }

    public function inicioMesPasado()
    {
        $s = Carbon::now()->subMonth()->startOfMonth();
        return $s->format($this->format);
    }

    public function finalMesPasado()
    {
        $e = Carbon::now()->subMonth()->endOfMonth();
        return  $e->format($this->format);
    }
    public function seisMesesAtras()
    {
        $e = Carbon::now()->subMonth(6)->startOfMonth();
        return  $e->format($this->format);
    }
    public function createDate($year, $month, $param)
    {
        $dt = $param == 'start' ? Carbon::create($year, $month, 1)->startOfMonth() : Carbon::create($year, $month, 1)->endOfMonth();
        return $dt->toDateString();
    }
    /**
     * Funcion Para Obtener El Mes
     *
     * @param int $month
     * @return string
     *
     */
    public function getMesString(int $month)
    {
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nomviembre', 'Diciembre'];
        return $meses[$month - 1];
    }
}
