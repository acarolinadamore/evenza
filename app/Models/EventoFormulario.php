<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoFormulario extends Model
{
    protected $table = 'evento_formularios';

    protected $fillable = [
        'evento_id',
        'nome',
        'slug',
        'mensagem_sucesso',
        'ordem',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function campos()
    {
        return $this->hasMany(FormularioCampo::class, 'formulario_id')->orderBy('ordem');
    }

    public function respostas()
    {
        return $this->hasMany(FormularioResposta::class, 'formulario_id');
    }
}
