<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'nome',
        'slug',
        'descricao',
        'data_evento',
        'local',
        'status',
        'capacidade',
        'valor_ingresso',
        'landing_page_ativa'
    ];

    protected $casts = [
        'data_evento' => 'datetime',
        'landing_page_ativa' => 'boolean'
    ];

    public function participantes()
    {
        return $this->hasMany(Participante::class);
    }

    public function tema()
    {
        return $this->hasOne(EventoTema::class);
    }

    public function blocos()
    {
        return $this->hasMany(EventoBloco::class)->orderBy('ordem');
    }

    public function formularios()
    {
        return $this->hasMany(EventoFormulario::class)->orderBy('ordem');
    }

    public function formularioRespostas()
    {
        return $this->hasMany(FormularioResposta::class);
    }
}