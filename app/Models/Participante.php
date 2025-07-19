<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}