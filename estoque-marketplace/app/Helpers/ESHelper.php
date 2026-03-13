<?php

namespace App\Helpers;

use App\Models\Produto;
use App\Models\Configuracao;

class ESHelper
{
    public static function getVariacoesBaixas()
    {
        // pega limite da configuração
        $config = Configuracao::first();
        $limite = $config ? $config->alerta_minimo_estoque : 15;

        return Produto::whereHas('variacoes', function($q) use ($limite) {
            $q->where('estoque', '<', $limite);
        })->with(['variacoes' => function($q) use ($limite) {
            $q->where('estoque', '<', $limite);
        }])->get();
    }
}
