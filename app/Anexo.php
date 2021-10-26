<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    protected $fillable = [
        'nombre', 'extension', 'archivo'
    ];
    public function anexable()
    {
        return $this->morphTo();
    }
}
