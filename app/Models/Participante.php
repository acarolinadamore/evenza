<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Participante extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'is_whatsapp',
        'evento_id',
        'observacoes',
        'data_nascimento',
        'idade',
        'sexo'
    ];

    protected $casts = [
        'is_whatsapp' => 'boolean',
        'data_nascimento' => 'date'
    ];

    /**
     * Calcula a idade baseada na data de nascimento
     */
    public function getIdadeAttribute()
    {
        if (!$this->data_nascimento) {
            return null;
        }

        return Carbon::parse($this->data_nascimento)->age;
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}