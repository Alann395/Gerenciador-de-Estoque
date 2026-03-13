<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\ProdutoVariacao;

class DashboardController extends Controller
{
    public function index()
    {
        // Pega configuração do alerta (ou 15 se não tiver nada)
        $config = Configuracao::first();
        $limite = $config->alerta_minimo_estoque ?? 15;

        // Busca TODAS variações abaixo do limite
        $variacoesBaixas = ProdutoVariacao::with('produto')
            ->where('estoque', '<', $limite)
            ->get();

        // Contador total → usado no dashboard e no sininho
        $totalAlertas = $variacoesBaixas->count();

        return view('dashboard', compact(
            'variacoesBaixas',
            'totalAlertas',
            'limite'
        ));
    }
}
