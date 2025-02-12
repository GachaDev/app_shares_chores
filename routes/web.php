<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::prefix('users')->group(base_path('routes/users/users.php'));
Route::prefix('chores')->group(base_path('routes/chores/chores.php'));
