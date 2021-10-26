<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'nombre',
    ];

    public function dependencia()
    {
        return $this->belongsTo('App\Dependencia');
    }
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnDopendencias($query, $id)
    {
        return $query->where('dependencia_id', $id)
            ->select('id', 'nombre')->get();
    }
}
