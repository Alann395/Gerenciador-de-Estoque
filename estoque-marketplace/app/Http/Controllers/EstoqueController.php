<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\ProdutoVariacao;
use App\Models\Movimentacao;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function buscarVariacoes(Request $request)
{
    $search = $request->input('search');

    $variacoes = ProdutoVariacao::with('produto')
        ->whereHas('produto', function ($query) use ($search) {
            $query->where('nome', 'LIKE', "%{$search}%");
        })
        ->orderByRaw('(SELECT nome FROM produtos WHERE produtos.id = produto_variacoes.produto_id) ASC')
        ->limit(40)
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->produto->nome
                        . ' — ' . $item->cor . ' ' . $item->tamanho
                        . ' (Atual: ' . $item->estoque . ')'
            ];
        });

    return response()->json(['results' => $variacoes]);
}

    public function index()
    {
        $variacoes = ProdutoVariacao::with('produto')->get();

        return view('estoque.index', compact('variacoes'));
    }

    public function movimentar(Request $request)
    {
        $request->validate([
            'variacao_id' => 'required|exists:produto_variacoes,id',
            'tipo' => 'required|in:entrada,saida',
            'quantidade' => 'required|integer|min:1',
            'motivo' => 'nullable|string'
        ]);

        $variacao = ProdutoVariacao::findOrFail($request->variacao_id);

        // Ajuste do estoque
        if ($request->tipo === 'entrada') {
            $variacao->estoque += $request->quantidade;
        } else {
            $variacao->estoque -= $request->quantidade;
        }

        $variacao->save();

        // Registra movimentação
        Movimentacao::create([
            'produto_variacao_id' => $variacao->id,
            'tipo' => $request->tipo,
            'quantidade' => $request->quantidade,
            'motivo' => $request->motivo
        ]);

        return back()->with('success', 'Movimentação registrada com sucesso!');
    }
  

     public function alertas()
     {
    $limite = env('ESTOQUE_MINIMO', 10);

    $produtosBaixoEstoque = Produto::whereHas('variacoes', function($q) use ($limite) {
        $q->where('estoque', '<', $limite);
    })->with(['variacoes' => function($q) use ($limite) {
        $q->where('estoque', '<', $limite);
    }])->get();

    return view('estoque.alertas', compact('produtosBaixoEstoque', 'limite'));
    }

     public function historico(Request $request)
      {
    $query = Movimentacao::with('variacao.produto');

    // FILTRO POR DIA
    if ($request->filled('dia')) {
        $query->whereDate('created_at', $request->dia);
    }

    // FILTRO POR MÊS
    if ($request->filled('mes')) {
        $query->whereMonth('created_at', substr($request->mes, 5, 2))
              ->whereYear('created_at', substr($request->mes, 0, 4));
    }

    // FILTRO POR HORA
    if ($request->filled('hora')) {
        $query->whereTime('created_at', '>=', $request->hora . ':00:00')
              ->whereTime('created_at', '<=', $request->hora . ':59:59');
    }

    $movs = $query->orderBy('id', 'DESC')->paginate(20)->withQueryString();

    return view('estoque.historico', compact('movs'));
}

}


