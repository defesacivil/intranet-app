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

    public function show($equipamento)
    {
        $equipamento = Equipamento::with(['categoria', 'registros'])
        ->findOrFail($equipamento);
        return view('inventario.equipamentos.show', compact('equipamento'));
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
            'patrimonio' => 'required|max:255',
            'categoria_id' => 'required|integer',
            'user_id' => 'nullable|integer',
            'situacao' => 'required|string|max:255',
            'diretoria' => 'required|string|max:255',
            'secao_diretoria' => 'required|string|max:255',
        ]);

        $dados = $request->only([
            'nome',
            'patrimonio',
            'categoria_id',
            'situacao',
            'diretoria',
            'secao_diretoria',
        ]);

        foreach ($dados as $key => $value) {
            if ($value === '') {
                $dados[$key] = null;
            }
        }

        try {
            $equipamento = Equipamento::create($dados);

            if ($request->filled('user_id')) {
                $userData = (new UsuarioController())->getSdcUserById($request->user_id)['data'][0] ?? null;
                $equipamento->responsavel = $userData['nome'] ?? null;
                $equipamento->save();

                EquipamentoUser::create([
                    'equipamento_id' => $equipamento->id,
                    'user_id' => $request->input('user_id'),
                ]);
            }

        } catch (\Exception $e) {
            dd('Erro ao criar equipamento: ' . $e->getMessage());
        }

        return redirect()->route('equipamentos.index')->with('success', 'Equipamento cadastrado com sucesso!');
    }



    public function edit(Equipamento $equipamento)
    {
        $usuarioControl = new UsuarioController();
        $usuarios = $usuarioControl->getSdcUsers()['data'];
        $categorias = Categoria::all();

        $equipamentoUser = EquipamentoUser::where('equipamento_id', $equipamento->id)->first();
        $userId = $equipamentoUser->user_id ?? null;

        return view('inventario.equipamentos.edit', compact('equipamento', 'categorias', 'usuarios', 'userId'));
    }

    public function update(Request $request, Equipamento $equipamento)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'patrimonio' => 'required|string|max:255',
            'categoria_id' => 'required|integer',
            'user_id' => 'nullable|integer',
            'situacao' => 'required|string|max:255',
            'diretoria' => 'required|string|max:255',
            'secao_diretoria' => 'required|string|max:255',
        ]);

        $dados = $request->only([
            'nome',
            'patrimonio',
            'categoria_id',
            'situacao',
            'diretoria',
            'secao_diretoria',
        ]);

        foreach ($dados as $key => $value) {
            if ($value === '') {
                $dados[$key] = null;
            }
        }

        $equipamento->update($dados);

        $userId = $request->input('user_id');

        if ($userId) {
            $userData = (new UsuarioController())->getSdcUserById($userId)['data'][0] ?? null;
            $equipamento->responsavel = $userData['nome'] ?? null;
            $equipamento->save();

            EquipamentoUser::updateOrCreate(
                ['equipamento_id' => $equipamento->id],
                ['user_id' => $userId]
            );
        } else {
            $equipamento->responsavel = null;
            $equipamento->save();

            EquipamentoUser::where('equipamento_id', $equipamento->id)->delete();
        }

        return redirect()->route('equipamentos.index')->with('success', 'Equipamento atualizado com sucesso!');
    }

    public function destroy(Equipamento $equipamento)
    {
        $equipamento->delete();
        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento deletado com sucesso!');
    }

    public function historico($equipamento)
    {
        $equipamentos = Equipamento::join('equipamentos_users','equipamentos_users.equipamento_id', '=', 'equipamentos.id')
            ->where('equipamentos.id', '=', $equipamento)
            ->orderBy('equipamentos_users.created_at')
            ->get();

        $equipamentosFormatados = $equipamentos->map(function ($equipamento) {
            $user = UsuarioController::getSdcUserById($equipamento->user_id);
            $equipamento->nomeUsuario = $user['data'][0]['nome'];
            return $equipamento;
        });

        return view('inventario.equipamentos.historico', ['equipamentos' => $equipamentosFormatados]);
    }
}
