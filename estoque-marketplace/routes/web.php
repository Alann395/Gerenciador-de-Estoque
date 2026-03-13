<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\ProdutoVariacaoController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MercadoLivreWebhookController;
use App\Http\Controllers\MercadoLivreAuthController;

Route::get(
    '/integracoes/mercado-livre/conectar',
    [MercadoLivreAuthController::class, 'redirect']
);

Route::get(
    '/integracoes/mercado-livre/callback',
    [MercadoLivreAuthController::class, 'callback']
)->name('ml.callback');

// ...

// Webhook do Mercado Livre (NÃO COLOCAR DENTRO DE middleware auth)
Route::post('/webhook/mercado-livre', [MercadoLivreWebhookController::class, 'handle'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);



// ROTA PÚBLICA — LOGIN
Route::get('/', function () {
    return redirect('/dashboard');
});


// ROTAS PARA QUALQUER USUÁRIO LOGADO (ADM E COLABORADOR)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/ajuste-estoque', [EstoqueController::class, 'index'])->name('estoque.index');
    Route::post('/ajuste-estoque', [EstoqueController::class, 'movimentar'])->name('estoque.movimentar');

    Route::get('/buscar-variacoes', [ProdutoVariacaoController::class, 'buscar'])
        ->name('buscar.variacoes');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// ROTAS APENAS ADM
Route::middleware(['auth', 'admin'])->group(function () {

    // PRODUTOS
    Route::resource('produtos', ProdutoController::class);

    // USUÁRIOS
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/novo', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // ALERTAS
    Route::get('/alertas-estoque', [EstoqueController::class, 'alertas'])
        ->name('estoque.alertas');

    // MOVIMENTAÇÕES
    Route::get('/movimentacoes', [MovimentacaoController::class, 'index'])
        ->name('movimentacoes.index');

    // CONFIGURAÇÕES
    Route::get('/configuracoes', [ConfiguracaoController::class, 'index'])->name('configuracoes.index');
    Route::post('/configuracoes', [ConfiguracaoController::class, 'update'])->name('configuracoes.update');
});

// PERFIL
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
