<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use App\Models\Participante;

class DadosTesteSeeder extends Seeder
{
    public function run(): void
    {
        $evento = new Evento();
        $evento->nome = "Workshop Laravel";
        $evento->descricao = "Curso de Laravel";
        $evento->data_evento = "2025-02-01";
        $evento->local = "IFMS Campo Grande";
        $evento->save();

        $participante = new Participante();
        $participante->nome = "Ana Carolina";
        $participante->email = "ana@email.com";
        $participante->telefone = "(67) 99999-9999";
        $participante->evento_id = 1;
        $participante->save();

        $evento2 = new Evento();
        $evento2->nome = "Palestra PHP";
        $evento2->descricao = "Palestra sobre PHP moderno";
        $evento2->data_evento = "2025-03-15";
        $evento2->local = "Auditório Central";
        $evento2->save();

        $participante2 = new Participante();
        $participante2->nome = "Maria Santos";
        $participante2->email = "maria@email.com";
        $participante2->telefone = "(67) 88888-8888";
        $participante2->evento_id = 2;
        $participante2->save();
    }
}