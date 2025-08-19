<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;

class Equipamento extends Model
{
    use HasFactory;

    protected $table = 'equipamentos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nome',
        'patrimonio',
        'categoria_id',
        'situacao',
        'diretoria',
        'secao_diretoria',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function atribuicaoAtual()
    {
        return $this->hasOne(EquipamentoUser::class)
                    ->whereNull('deleted_at')
                    ->latestOfMany();
    }

    public function usuarioAtual()
    {
        return $this->hasOneThrough(
                    \App\Models\Usuario::class,
                    EquipamentoUser::class,
                    'equipamento_id',
                    'id',            
                    'id',           
                    'user_id'         
                )
                ->whereNull('equipamentos_users.deleted_at');
    }

}
