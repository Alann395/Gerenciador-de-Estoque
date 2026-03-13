<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegracaoPedido extends Model
{
    protected $table = 'integracao_pedidos';

    protected $fillable = [
        'marketplace',
        'pedido_id_plataforma',
        'status',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
    
    public function conta()
    {
        return $this->belongsTo(MercadoLivreConta::class, 'mercado_livre_conta_id');
    }

}

