<?php

namespace App\Http\Controllers;

use App\Models\IntegracaoPedido;
use App\Models\Movimentacao;
use App\Models\ProdutoVariacao;
use App\Models\MercadoLivreConta;
use App\Services\Marketplaces\MercadoLivre\MercadoLivreService;
use Illuminate\Http\Request;

class MercadoLivreWebhookController extends Controller
{
    public function venda(Request $request, MercadoLivreService $ml)
    {
        // 🔐 Segurança do webhook
        if ($request->header('X-Webhook-Token') !== env('ML_WEBHOOK_TOKEN')) {
            return response()->json(['ok' => false], 401);
        }

        // 🧾 Conta do Mercado Livre (por enquanto fixa)
        // Depois: identificação via header ou seller_id
        $conta = MercadoLivreConta::where('ativo', true)->firstOrFail();

        // 📦 Normaliza payload
        $dados = $ml->processarVenda($request->all());

        $pedidoId = $dados['pedido_id'] ?? null;

        if (!$pedidoId) {
            return response()->json([
                'ok' => false,
                'message' => 'Pedido inválido'
            ], 422);
        }

        // 🚫 Idempotência por CONTA + PEDIDO
        if (IntegracaoPedido::where('marketplace', 'mercado_livre')
            ->where('mercado_livre_conta_id', $conta->id)
            ->where('pedido_id_plataforma', $pedidoId)
            ->exists()) {

            return response()->json([
                'ok' => true,
                'message' => 'Pedido já processado'
            ]);
        }

        $logs = [];

        foreach ($dados['items'] as $item) {

            if (empty($item['sku']) || $item['quantidade'] <= 0) {
                continue;
            }

            $variacao = ProdutoVariacao::where('sku', $item['sku'])->first();

            if (!$variacao) {
                $logs[] = [
                    'sku' => $item['sku'],
                    'status' => 'sku_nao_encontrado'
                ];
                continue;
            }

            $estoqueAntes = $variacao->estoque;
            $variacao->estoque -= $item['quantidade'];
            $variacao->save();

            Movimentacao::create([
                'produto_variacao_id' => $variacao->id,
                'tipo' => 'saida',
                'quantidade' => $item['quantidade'],
                'motivo' => 'Venda Mercado Livre #' . $pedidoId,
            ]);

            $logs[] = [
                'sku' => $item['sku'],
                'quantidade' => $item['quantidade'],
                'antes' => $estoqueAntes,
                'depois' => $variacao->estoque,
                'status' => 'ok'
            ];
        }

        // 🧾 Registro da integração
        IntegracaoPedido::create([
            'marketplace' => 'mercado_livre',
            'mercado_livre_conta_id' => $conta->id,
            'pedido_id_plataforma' => $pedidoId,
            'status' => 'processado',
            'payload' => $request->all(),
        ]);

        return response()->json([
            'ok' => true,
            'pedido_id' => $pedidoId,
            'itens' => $logs
        ]);
    }

    public function cancelamento(Request $request, MercadoLivreService $ml)
    {
        // 🔐 Segurança
        if ($request->header('X-Webhook-Token') !== env('ML_WEBHOOK_TOKEN')) {
            return response()->json(['ok' => false], 401);
        }

        $conta = MercadoLivreConta::where('ativo', true)->firstOrFail();

        $dados = $ml->processarCancelamento($request->all());
        $pedidoId = $dados['pedido_id'] ?? null;

        if (!$pedidoId) {
            return response()->json(['ok' => false], 422);
        }

        $integracao = IntegracaoPedido::where('marketplace', 'mercado_livre')
            ->where('mercado_livre_conta_id', $conta->id)
            ->where('pedido_id_plataforma', $pedidoId)
            ->first();

        if (!$integracao) {
            return response()->json([
                'ok' => false,
                'message' => 'Pedido não encontrado'
            ], 404);
        }

        // 🔁 Proteção contra devolução duplicada
        if ($integracao->status === 'devolvido') {
            return response()->json([
                'ok' => true,
                'message' => 'Pedido já devolvido'
            ]);
        }

        foreach ($dados['items'] as $item) {

            if (empty($item['sku']) || $item['quantidade'] <= 0) {
                continue;
            }

            $variacao = ProdutoVariacao::where('sku', $item['sku'])->first();
            if (!$variacao) continue;

            $variacao->estoque += $item['quantidade'];
            $variacao->save();

            Movimentacao::create([
                'produto_variacao_id' => $variacao->id,
                'tipo' => 'entrada',
                'quantidade' => $item['quantidade'],
                'motivo' => 'Devolução Mercado Livre #' . $pedidoId,
            ]);
        }

        $integracao->status = 'devolvido';
        $integracao->save();

        return response()->json([
            'ok' => true,
            'message' => 'Estoque devolvido com sucesso'
        ]);
    }
}
