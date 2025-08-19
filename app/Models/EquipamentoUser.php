<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipamentoUser extends Model
{
    use SoftDeletes;

    protected $table = 'equipamentos_users';

    protected $fillable = [
        'equipamento_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
}
