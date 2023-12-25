<?php

use App\Http\Controllers\Stagiaire;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stagiaires/create', [Stagiaire::class, 'create'])->name('stagiaires.create');
Route::get('/stagiaires', [Stagiaire::class, 'index'])->name('stagiaires');



Route::post('/stagiaires/create', [Stagiaire::class, 'store'])->name('addStag');
Route::get('/stagiaires/{stagiaireModel}', [Stagiaire::class, 'show'])->name('show.stag');
Route::get('/stagiaires/{stagiaireModel}/edit', [Stagiaire::class, 'edit'])->name('edit.stag');

Route::put('/stagiaires/{stagiaireModel}', [Stagiaire::class, 'update'])->name('updateStag');
Route::delete('/stagiaires/{stagiaireModel}', [Stagiaire::class, 'destroy'])->name('delete.stag');
