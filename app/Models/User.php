<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
//use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
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
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
