<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MercadoLivreWebhookController;

Route::post('/webhook/mercado-livre', [MercadoLivreWebhookController::class, 'venda']);

Route::get('/ping', function () {
    return 'pong';
});


Route::post('/webhook/mercado-livre/cancelamento',[MercadoLivreWebhookController::class, 'cancelamento']
);