<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileOrden extends Model
{
    protected $fillable = [
        'nombre', 'extension', 'archivo'
    ];
    public function ordenable()
    {
        return $this->morphTo();
    }
}
