<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipamento;

class DashboardController extends Controller 
{
    public function index()
    {
        $totaisEquipamentos = Equipamento::groupBy('situacao')->selectRaw('situacao, count(*) as count')->get();
        $totalPorCategorias = Equipamento::join('categorias', 'categorias.id', '=', 'equipamentos.categoria_id')
            ->groupBy('categoria_id')
            ->selectRaw('categorias.nome,categoria_id, count(*) as count')
            ->get();
        return view('inventario.dashboard.index', compact('totaisEquipamentos','totalPorCategorias'));
    }

}
