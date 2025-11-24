<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoTema extends Model
{
    protected $table = 'evento_temas';

    protected $fillable = [
        'evento_id',
        'imagem_fundo',
        'cor_principal',
        'cor_destaque',
        'logo',
        'template_mensagem_compartilhar'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
