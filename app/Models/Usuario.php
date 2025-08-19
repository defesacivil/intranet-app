<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'ativo',
        'id_user_cedec',
        'cpf',
        'tipo',
        'sub_tipo',
        'municipio_id',
        'api_token',
        'login',
        'id_empdor',
        'email_alt',
        'telefone',
        'masp',
        'created_at',
        'updated_at'
    ];

    public function atribuicoes()
    {
        return $this->hasMany(EquipamentoUser::class)->with('equipamento');
    }

    public function equipamentosAtivos()
    {
        return $this->hasMany(EquipamentoUser::class, 'user_id', 'id')
                    ->whereNull('deleted_at')
                    ->with('equipamento');
    }

}
