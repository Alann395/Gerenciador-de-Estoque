<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MercadoLivreConta;

class MercadoLivreAuthController extends Controller
{
    // 🔗 Redireciona para login do Mercado Livre
    public function redirect()
    {
        $clientId = config('services.mercadolivre.client_id');
        $redirectUri = route('ml.callback');

        $url = "https://auth.mercadolivre.com.br/authorization";
        $url .= "?response_type=code";
        $url .= "&client_id={$clientId}";
        $url .= "&redirect_uri={$redirectUri}";

        return redirect($url);
    }

    // 🔄 Callback do Mercado Livre
    public function callback(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            abort(400, 'Code OAuth não recebido');
        }

        // 🔐 Troca code por tokens
        $response = Http::asForm()->post(
            'https://api.mercadolibre.com/oauth/token',
            [
                'grant_type'    => 'authorization_code',
                'client_id'     => config('services.mercadolivre.client_id'),
                'client_secret'=> config('services.mercadolivre.client_secret'),
                'code'          => $code,
                'redirect_uri'  => route('ml.callback'),
            ]
        );

        $data = $response->json();

        if (!isset($data['access_token'])) {
            abort(500, 'Erro ao obter token do Mercado Livre');
        }

        // 👤 Busca dados da conta (seller)
        $user = Http::withToken($data['access_token'])
            ->get('https://api.mercadolibre.com/users/me')
            ->json();

        // 💾 Salva ou atualiza conta
        MercadoLivreConta::updateOrCreate(
            ['seller_id' => $user['id']],
            [
                'nome'             => $user['nickname'] ?? 'Conta Mercado Livre',
                'client_id'        => config('services.mercadolivre.client_id'),
                'client_secret'    => config('services.mercadolivre.client_secret'),
                'access_token'     => $data['access_token'],
                'refresh_token'    => $data['refresh_token'],
                'token_expires_at' => now()->addSeconds($data['expires_in']),
                'ativo'            => true,
            ]
        );

        return redirect('/dashboard')
            ->with('success', 'Conta Mercado Livre conectada com sucesso!');
    }
}
