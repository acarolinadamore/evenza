<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\ParticipantesController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\FormularioPublicoController;
use App\Http\Controllers\EventoLandingPageController;
use App\Http\Controllers\EventoBlocoController;
use App\Http\Controllers\EventoFormularioController;
use App\Http\Controllers\FormularioRespostaController;
use App\Http\Controllers\CompartilhamentoController;

Route::get('/', function () {
    return redirect('/site');
});

Route::get('/site', function () {
    return view('site'); 
})->name('site');

Route::get('/painel', [DashboardController::class, 'index'])->name('painel');

Route::get('/eventos', [EventosController::class, 'index']);
Route::get('/eventos/novo', [EventosController::class, 'create']);
Route::get('/eventos/{id}', [EventosController::class, 'show']);
Route::get('/eventos/editar/{id}', [EventosController::class, 'edit']);
Route::post('/eventos/salvar', [EventosController::class, 'store']);
Route::delete('/eventos/excluir', [EventosController::class, 'destroy']);
Route::put('/eventos/alterar', [EventosController::class, 'update']);

// Página pública do evento
Route::get('/evento/{slug}', [EventosController::class, 'paginaPublica'])->name('evento.publico');
Route::post('/evento/{slug}/inscricao', [EventosController::class, 'inscricaoPublica'])->name('evento.inscricao');

Route::get('/participantes', [ParticipantesController::class, 'index']);
Route::get('/participantes/novo', [ParticipantesController::class, 'create']);
Route::get('/participantes/{id}', [ParticipantesController::class, 'show']);
Route::get('/participantes/editar/{id}', [ParticipantesController::class, 'edit']);
Route::post('/participantes/salvar', [ParticipantesController::class, 'store']);
Route::delete('/participantes/excluir', [ParticipantesController::class, 'destroy']);
Route::put('/participantes/alterar', [ParticipantesController::class, 'update']);

// ===== ROTAS DE LANDING PAGE (ADMIN) =====

// Configuração da landing page do evento
Route::get('/eventos/{evento}/landing-page', [EventoLandingPageController::class, 'edit'])->name('eventos.landing-page.edit');
Route::put('/eventos/{evento}/landing-page', [EventoLandingPageController::class, 'update'])->name('eventos.landing-page.update');
Route::get('/eventos/{evento}/landing-page/preview', [EventoLandingPageController::class, 'preview'])->name('eventos.landing-page.preview');

// Gerenciamento de blocos de conteúdo
Route::get('/eventos/{evento}/blocos', [EventoBlocoController::class, 'index'])->name('eventos.blocos.index');
Route::get('/eventos/{evento}/blocos/novo', [EventoBlocoController::class, 'create'])->name('eventos.blocos.create');
Route::post('/eventos/{evento}/blocos', [EventoBlocoController::class, 'store'])->name('eventos.blocos.store');
Route::get('/eventos/{evento}/blocos/{bloco}/editar', [EventoBlocoController::class, 'edit'])->name('eventos.blocos.edit');
Route::put('/eventos/{evento}/blocos/{bloco}', [EventoBlocoController::class, 'update'])->name('eventos.blocos.update');
Route::delete('/eventos/{evento}/blocos/{bloco}', [EventoBlocoController::class, 'destroy'])->name('eventos.blocos.destroy');
Route::post('/eventos/{evento}/blocos/reordenar', [EventoBlocoController::class, 'reorder'])->name('eventos.blocos.reorder');

// Gerenciamento de formulários
Route::get('/eventos/{evento}/formularios', [EventoFormularioController::class, 'index'])->name('eventos.formularios.index');
Route::get('/eventos/{evento}/formularios/novo', [EventoFormularioController::class, 'create'])->name('eventos.formularios.create');
Route::post('/eventos/{evento}/formularios', [EventoFormularioController::class, 'store'])->name('eventos.formularios.store');
Route::get('/eventos/{evento}/formularios/{formulario}/editar', [EventoFormularioController::class, 'edit'])->name('eventos.formularios.edit');
Route::put('/eventos/{evento}/formularios/{formulario}', [EventoFormularioController::class, 'update'])->name('eventos.formularios.update');
Route::delete('/eventos/{evento}/formularios/{formulario}', [EventoFormularioController::class, 'destroy'])->name('eventos.formularios.destroy');
Route::post('/eventos/{evento}/formularios/reordenar', [EventoFormularioController::class, 'reorder'])->name('eventos.formularios.reorder');

// Visualização de respostas dos formulários
Route::get('/eventos/{evento}/formularios/{formulario}/respostas', [FormularioRespostaController::class, 'index'])->name('eventos.formularios.respostas.index');
Route::get('/eventos/{evento}/formularios/{formulario}/respostas/{resposta}', [FormularioRespostaController::class, 'show'])->name('eventos.formularios.respostas.show');
Route::delete('/eventos/{evento}/formularios/{formulario}/respostas/{resposta}', [FormularioRespostaController::class, 'destroy'])->name('eventos.formularios.respostas.destroy');
Route::get('/eventos/{evento}/formularios/{formulario}/respostas/exportar', [FormularioRespostaController::class, 'export'])->name('eventos.formularios.respostas.export');

// Compartilhamento
Route::get('/eventos/{evento}/compartilhar', [CompartilhamentoController::class, 'evento'])->name('eventos.compartilhar');
Route::get('/eventos/{evento}/participantes/{participante}/compartilhar', [CompartilhamentoController::class, 'participante'])->name('eventos.participantes.compartilhar');
Route::post('/compartilhamento/gerar-link', [CompartilhamentoController::class, 'gerarLink'])->name('compartilhamento.gerar-link');

// ===== ROTAS PÚBLICAS DA LANDING PAGE =====

// Submissão de formulário público
Route::post('/{eventoSlug}/formulario/{formularioSlug}', [FormularioPublicoController::class, 'submit'])->name('landing-page.formulario.submit');

// Landing page pública (deve ser a última rota para não capturar as outras)
Route::get('/{slug}', [LandingPageController::class, 'show'])->name('landing-page.show');