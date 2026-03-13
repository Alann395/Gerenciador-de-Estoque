<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MercadoLivreConta extends Model
{
    protected $fillable = ['nome', 'seller_id', 'ativo'];

    public function pedidos()
    {
        return $this->hasMany(IntegracaoPedido::class);
    }
}

