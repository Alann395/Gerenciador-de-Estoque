<?php

namespace App\Services\Marketplaces\MercadoLivre;

use App\Services\Marketplaces\MarketplaceServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\MercadoLivreConta;

class MercadoLivreService implements MarketplaceServiceInterface
{
    public function renovarToken(MercadoLivreConta $conta): void
    {
        // ⏱ Ainda válido? Não faz nada
        if ($conta->token_expires_at && now()->lt($conta->token_expires_at)) {
            return;
        }

        $response = Http::asForm()->post(
            'https://api.mercadolibre.com/oauth/token',
            [
                'grant_type'    => 'refresh_token',
                'client_id'     => $conta->client_id,
                'client_secret'=> $conta->client_secret,
                'refresh_token'=> $conta->refresh_token,
            ]
        );

        if (!$response->successful()) {
            throw new \Exception('Erro ao renovar token Mercado Livre');
        }

        $data = $response->json();

        $conta->update([
            'access_token'     => $data['access_token'],
            'refresh_token'    => $data['refresh_token'],
            'token_expires_at' => now()->addSeconds($data['expires_in']),
        ]);
    }
    
    public function processarVenda(array $payload): array
    {
        return [
            'pedido_id' => $payload['id'] ?? null,
            'items' => collect($payload['order_items'] ?? [])
                ->map(fn ($item) => [
                    'sku'        => $item['item']['seller_sku'] ?? null,
                    'quantidade' => $item['quantity'] ?? 0,
                ])
                ->toArray()
        ];
    }

    public function processarCancelamento(array $payload): array
    {
        return [
            'pedido_id' => $payload['id'] ?? null,
            'items' => collect($payload['items'] ?? [])
                ->map(fn ($item) => [
                    'sku'        => $item['seller_sku'] ?? null,
                    'quantidade' => $item['quantity'] ?? 0,
                ])
                ->toArray()
        ];
    }
}
