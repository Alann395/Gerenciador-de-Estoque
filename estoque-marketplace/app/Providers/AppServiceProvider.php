<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Configuracao;
use App\Models\ProdutoVariacao;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔔 Compartilha informações de estoque baixo com o layout principal
        View::composer('layouts.app', function ($view) {

            // Busca configuração do alerta
            $config = Configuracao::first();
            $limite = $config ? $config->alerta_minimo_estoque : 15;

            // Variações que estão abaixo do limite
            $variacoesBaixoEstoque = ProdutoVariacao::with('produto')
                ->where('estoque', '<', $limite)
                ->get();

            $view->with([
                'variacoesBaixoEstoque' => $variacoesBaixoEstoque,
                'limiteEstoqueMinimo'   => $limite,
            ]);
        });
    }
}

