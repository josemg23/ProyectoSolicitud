<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dependencia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
    ];


    public function departamentos()
    {
        return $this->hasMany('App\Departamento');
    }
}
