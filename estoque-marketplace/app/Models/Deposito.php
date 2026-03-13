<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    protected $fillable = [
        'cliente_id',
        'nome',
        'tipo',
        'ativo'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function saldos()
    {
        return $this->hasMany(SaldoEstoque::class);
    }
}
