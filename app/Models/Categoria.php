<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Equipamento;

class Categoria extends Model
{
    protected $fillable = ['nome'];

    public function equipamento()
    {
        return $this->hasMany(Equipamento::class);
    }

}

