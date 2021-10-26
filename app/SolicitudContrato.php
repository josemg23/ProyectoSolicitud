<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudContrato extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['solicitud_id', 'productos'];
}
