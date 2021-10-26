<?php

namespace App\Traits;


trait ContratoSuministroTrait
{
    function convertArray($productos)
    {
        $sync = [];
        foreach ($productos as $key => $item) {
            $sync[$item['id']] = array(
                'cantidad' => $item['cantidad'],
            );
        }
        return $sync;
    }
}
