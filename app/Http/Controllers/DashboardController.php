<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Participante;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEventos = Evento::count();
        $totalParticipantes = Participante::count();
        
        return view('painel', [
            'totalEventos' => $totalEventos,
            'totalParticipantes' => $totalParticipantes,
        ]);
    }
}