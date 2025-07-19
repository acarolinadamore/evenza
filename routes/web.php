<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\ParticipantesController;

Route::get('/', function () {
    return redirect('/site');
});

Route::get('/site', function () {
    return view('site'); 
})->name('site');

Route::get('/painel', [DashboardController::class, 'index'])->name('painel');

Route::get('/eventos', [EventosController::class, 'index']);
Route::get('/eventos/novo', [EventosController::class, 'create']);
Route::get('/eventos/editar/{id}', [EventosController::class, 'edit']);
Route::post('/eventos/salvar', [EventosController::class, 'store']);
Route::delete('/eventos/excluir', [EventosController::class, 'destroy']);
Route::put('/eventos/alterar', [EventosController::class, 'update']);

Route::get('/participantes', [ParticipantesController::class, 'index']);
Route::get('/participantes/novo', [ParticipantesController::class, 'create']);
Route::get('/participantes/editar/{id}', [ParticipantesController::class, 'edit']);
Route::post('/participantes/salvar', [ParticipantesController::class, 'store']);
Route::delete('/participantes/excluir', [ParticipantesController::class, 'destroy']);
Route::put('/participantes/alterar', [ParticipantesController::class, 'update']);