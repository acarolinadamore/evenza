<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoBloco extends Model
{
    protected $table = 'evento_blocos';

    protected $fillable = [
        'evento_id',
        'tipo',
        'ordem',
        'ativo',
        'conteudo'
    ];

    protected $casts = [
        'conteudo' => 'array',
        'ativo' => 'boolean'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
