<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registros extends Model
{
    use HasFactory;

    const TIPO_MANUTENCAO   = 'manutencao';
    const TIPO_MOVIMENTACAO = 'movimentacao';
    const TIPO_CHAMADO      = 'chamado';
    const TIPO_INSPECAO     = 'inspecao';
    const TIPO_UPGRADE      = 'upgrade';
    const TIPO_BAIXA        = 'baixa';

    protected $table = 'registros';

    protected $fillable = [
        'equipamento_id',
        'tipo',
        'descricao',
    ];

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
}
