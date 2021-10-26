<?php

namespace App\Traits;

trait RutasTraits {

/**
 * Undocumented function
 *
 * @return \Illuminate\Http\JsonResponse
 */
static public function rutas()
{
   $rutas = array(
       'solicitudes/insumos-y-servicios',
       'solicitudes/insumos-y-servicios',
    );
   return $rutas;
}
}
