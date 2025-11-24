<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespostaValor extends Model
{
    protected $table = 'resposta_valores';

    protected $fillable = [
        'resposta_id',
        'campo_id',
        'valor'
    ];

    public function resposta()
    {
        return $this->belongsTo(FormularioResposta::class, 'resposta_id');
    }

    public function campo()
    {
        return $this->belongsTo(FormularioCampo::class, 'campo_id');
    }
}
