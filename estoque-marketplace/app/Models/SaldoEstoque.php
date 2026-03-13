<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoEstoque extends Model
{
    protected $table = 'saldos_estoque';

    protected $fillable = [
        'produto_id',
        'deposito_id',
        'quantidade_disponivel',
        'quantidade_reservada'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function deposito()
    {
        return $this->belongsTo(Deposito::class);
    }
}
