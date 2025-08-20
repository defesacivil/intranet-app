<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Equipamento;
use App\Models\EquipamentoUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsuarioController extends Controller
{
    public function getSdcUsers()
    {
        $usersUrl = "http://www.sdc.mg.gov.br/api/sdc/user/all"; 

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-li-format'  => 'json',
            
        ])->acceptJson()
        ->get($usersUrl);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao conectar a api .');
        }

        return $response->json();
       
    }

    public function getSdcUserById($id)
    {
        
        $userUrl = "http://www.sdc.mg.gov.br/api/sdc/user/{$id}";
       
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-li-format'  => 'json',
        ])->acceptJson()->get($userUrl);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao conectar à API.');
        }

        return $response->json(); 
    }


    public function index()
    { 
        $users = $this->getSdcUsers()['data'];
        $todosEquipamentos = Equipamento::all();
        return view('inventario.usuarios.index', compact('users'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request){
        
        $request->validate([
            'equipamentos.add' => 'array',
            'equipamentos.add.*' => 'exists:equipamentos,id',
            'equipamentos.remove' => 'array',
            'equipamentos.remove.*' => 'exists:equipamentos,id',
        ]);

        if(!empty($request->input('equipamentos.add'))){
            foreach ($request->input('equipamentos.add') as $adicionar) {
                $arrayAdicionar = [
                    'equipamento_id' => $adicionar,
                    'user_id' => $request->input('equipamentos.user'),
                ];
                EquipamentoUser::create($arrayAdicionar);
                Equipamento::where('id', $adicionar)->update(['situacao' => 'Em Uso']);
            }
        }
        if(!empty($request->input('equipamentos.remove'))){
            foreach ($request->input('equipamentos.remove') as $remover) {
                $equipamentoUser = EquipamentoUser::select()->where('equipamento_id', '=', $remover)->first();
                $equipamentoUser->delete();
                Equipamento::where('id', $remover)->update(['situacao' => 'Disponivel']);
            }
        }
    }

    /*public function storeSdcUsers()
    {
        $users = json_decode($this->getSdcUsers());
                
        foreach ($users->data as $userData) {
            $userData->password = '$12$KrZRc7.nY.fFrrJy9TptOexgkAWyiDcg7oXMsTi9H/NdQjejyCTqC';
            
            if (!empty($userData->email_verified_at)) {
                $userData->email_verified_at = date('Y-m-d H:i:s', strtotime($userData->email_verified_at));
            }

            Usuario::create((array) $userData);
        }
    }*/

    public function edit($id)
    {
        $usuario = $this->getSdcUserById($id)['data'][0];

        $usuarioEquipamentos = EquipamentoUser::with('equipamento')
            ->where('user_id', $usuario['id_usuario'])
            ->whereNull('deleted_at')
            ->get();

        $equipamentosDisponiveis = Equipamento::whereNotIn('id', function($query) {
            $query->select('equipamento_id')
                ->from('equipamentos_users')
                ->whereNull('deleted_at'); 
        })->paginate(10);


        return view('inventario.usuarios.edit', compact('usuario', 'equipamentosDisponiveis', 'usuarioEquipamentos'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => "required|email|unique:usuarios,email,{$usuario->id}",
            'telefone' => 'nullable|string|max:20',
        ]);

        $usuario->update($request->all());

        return redirect()->route('inventario.usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('inventario.usuarios.index')->with('success', 'Usuário deletado com sucesso!');
    }

    public function transferirEquipamento(Request $request)
    {
        $request->validate([
            'equipamento_id' => 'required|exists:equipamentos,id',
            'user_id' => 'required|exists:usuarios,id',
        ]);

        $equipamento = Equipamento::find($request->equipamento_id);
        $equipamento->user_id = $request->user_id;
        $equipamento->save();

        return redirect()->back()->with('success', 'Equipamento transferido com sucesso!');
    }
}
