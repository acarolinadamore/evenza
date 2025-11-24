<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioCampo extends Model
{
    protected $table = 'formulario_campos';

    protected $fillable = [
        'formulario_id',
        'tipo',
        'label',
        'placeholder',
        'opcoes',
        'obrigatorio',
        'ordem'
    ];

    protected $casts = [
        'opcoes' => 'array',
        'obrigatorio' => 'boolean'
    ];

    public function formulario()
    {
        return $this->belongsTo(EventoFormulario::class, 'formulario_id');
    }

    public function valores()
    {
        return $this->hasMany(RespostaValor::class, 'campo_id');
    }
}
