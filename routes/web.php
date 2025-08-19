<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/equipamentos', [EquipamentoController::class, 'index'])->name('equipamentos.index');
Route::get('/equipamentos/create', [EquipamentoController::class, 'create'])->name('equipamentos.create');
Route::post('/equipamentos/store', [EquipamentoController::class, 'store'])->name('equipamentos.store');
Route::get('/equipamentos/{equipamento}/edit', [EquipamentoController::class, 'edit'])->name('equipamentos.edit');
Route::put('/equipamentos/{equipamento}', [EquipamentoController::class, 'update'])->name('equipamentos.update');
Route::delete('/equipamentos/{equipamento}', [EquipamentoController::class, 'destroy'])->name('equipamentos.destroy');

Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
Route::get('/categorias/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios/store', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');


require __DIR__.'/auth.php';
