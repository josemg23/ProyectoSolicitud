<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogError extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['exception', 'payload'];
}
