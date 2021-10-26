<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medida extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
    ];




    public function Producto()
    {
        return $this->HasMany('App\Product');
    }
}
