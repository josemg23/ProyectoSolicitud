<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smantenimiento extends Model
{
    // protected $table = 'smantenimientos';

    protected $fillable = ['solicitud_id', 'proveedor_id'];

    public function productos()
    {

        return $this->belongsToMany('App\Product', 'products_smantenimientos')->withPivot('cantidad', 'neto');
    }
}
