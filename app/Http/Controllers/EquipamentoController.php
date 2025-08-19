<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UsuarioController;
use App\Models\Equipamento;
use App\Models\Categoria;
use App\Models\Usuario;
use App\Models\EquipamentoUser;
use Illuminate\Http\Request;

class EquipamentoController extends Controller 
{
    public function index()
    {
        $equipamentos = Equipamento::with('categoria','atribuicaoAtual')->paginate(10);
        return view('inventario.equipamentos.index', compact('equipamentos'));
    }

    public function create()
    {
        $usuarioControl = new UsuarioController();
        $usuarios = $usuarioControl->getSdcUsers()['data'];
        $categorias = Categoria::all();
        return view('inventario.equipamentos.create', compact('categorias', 'usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'patrimonio' => "required|max:255",
            'categoria_id' => 'required|int|max:255',
            'user_id' => 'required|string|max:255',
            'situacao' => 'required|string|max:255',
            'diretoria' => 'required|string|max:255',
            'secao_diretoria' => 'required|string|max:255',
        ]);
        $equipamento = Equipamento::create($request->all());
        if($equipamento->id){
            $arrayAdicionar = [
                'equipamento_id' => $equipamento->id,
                'user_id' => $request->input('user_id'),
            ];
            EquipamentoUser::create($arrayAdicionar);
        }

        return redirect()->route('equipamentos.index')->with('success', 'Equipamento cadastrado com sucesso!');
    }

    public function edit(Equipamento $equipamento)
    {
        $usuarioControl = new UsuarioController();
        $usuarios = $usuarioControl->getSdcUsers()['data'];
        $categorias = Categoria::all();
        return view('inventario.equipamentos.edit', compact('equipamento', 'categorias', 'usuarios'));
    }

    public function update(Request $request, Equipamento $equipamento)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'patrimonio' => "required|",
            'categoria' => 'required|int|max:255',
            'responsavel' => 'required|string|max:255',
            'situacao' => 'required|string',
            'diretoria' => 'required|string|max:255',
            'secao_diretoria' => 'required|string|max:255',
        ]);

        $equipamento->update($request->all());

        return redirect()->route('equipamentos.index')->with('success', 'Equipamento atualizado com sucesso!');
    }

    public function destroy(Equipamento $equipamento)
    {
        $equipamento->delete();
        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento deletado com sucesso!');
    }
}
