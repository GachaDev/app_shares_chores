<?php

use App\Http\Controllers\ChoreController;
use Illuminate\Support\Facades\Route;

// RUTA PARA ENRUTAR /chores/hecha
Route::post('/chores/hecha/{chore}', [ChoreController::class, 'doMarkChoreAsDone'])->name('chore.doMarkChoreAsDone');

// RUTA PARA ENRUTAR /chores/borrar
Route::post('/chores/borrar/{chore}', [ChoreController::class, 'doDeleteChore'])->name('chore.doDeleteChore');