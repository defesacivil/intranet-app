<?php

namespace App\Http\Controllers;

use App\Models\Registros;
use Illuminate\Http\Request;

class RegistrosController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'equipamento_id' => 'required|exists:equipamentos,id',
            'tipo'           => 'required|in:manutencao,movimentacao,chamado,inspecao,upgrade,baixa',
            'descricao'      => 'required|string|max:1000',
        ]);

        Registros::create($request->all());

        return redirect()->back()->with('success', 'Registro adicionado com sucesso!');
    }

    public function update(Request $request, Registros $registro)
    {
        $request->validate([
            'tipo'      => 'required|in:manutencao,movimentacao,chamado,inspecao,upgrade,baixa',
            'descricao' => 'required|string|max:1000',
        ]);

        $registro->update($request->all());

        return redirect()->back()->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy(Registros $registro)
    {
        $registro->delete();

        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }
}
