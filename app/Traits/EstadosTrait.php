<?php

namespace App\Traits;

use App\Rechazo;

trait EstadosTrait
{
    public function getStatus(): object
    {
        return $estados = Rechazo::get(['id', 'nombre', 'slug']);
    }
}
