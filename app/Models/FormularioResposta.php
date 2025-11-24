<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioResposta extends Model
{
    protected $table = 'formulario_respostas';

    protected $fillable = [
        'formulario_id',
        'evento_id',
        'ip_origem',
        'user_agent'
    ];

    public function formulario()
    {
        return $this->belongsTo(EventoFormulario::class, 'formulario_id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function valores()
    {
        return $this->hasMany(RespostaValor::class, 'resposta_id');
    }
}
