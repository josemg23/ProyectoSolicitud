<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rechazo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'nombre', 'estado'];
}
