<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoVariacao;

class ProdutoVariacaoController extends Controller
{
    public function buscar(Request $request)
    {
        $search = $request->search ?? '';

        $variacoes = ProdutoVariacao::with('produto')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('produto', function ($q) use ($search) {
                    $q->where('nome', 'LIKE', "%{$search}%");
                })
                ->orWhere('cor', 'LIKE', "%{$search}%")
                ->orWhere('tamanho', 'LIKE', "%{$search}%");
            })
            ->orderByRaw('LOWER(cor)')
            ->orderByRaw('LOWER(tamanho)')
            ->limit(50)
            ->get();

        $formatted = [];

        foreach ($variacoes as $v) {
            $formatted[] = [
                'id' => $v->id,
                'text' => $v->produto->nome . ' — ' . $v->cor . ' ' . $v->tamanho . ' (Atual: ' . $v->estoque . ')'
            ];
        }

        return response()->json(['results' => $formatted]);
    }
}
