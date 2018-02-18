<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        'texto',
        ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
