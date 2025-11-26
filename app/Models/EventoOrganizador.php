<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoOrganizador extends Model
{
    protected $table = 'evento_organizadores';

    protected $fillable = [
        'evento_id',
        'nome',
        'cargo',
        'email',
        'telefone',
        'is_whatsapp',
        'ordem'
    ];

    protected $casts = [
        'is_whatsapp' => 'boolean'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
