<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProdutoVariacao;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProdutoController extends Controller
{
    // LISTAGEM
public function index(Request $request)
{
    // Inicia trazendo também as variações
    $query = Produto::with('variacoes');

    // FILTRO DE BUSCA (nome ou SKU)
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('nome', 'LIKE', "%{$search}%")
              ->orWhere('sku_interno', 'LIKE', "%{$search}%");
        });
    }

    // FILTRO DE ATIVO / INATIVO
    if ($request->filled('ativo')) {
        $query->where('ativo', $request->ativo);
    }

    // Ordenação
    $query->orderBy('id', 'DESC');

    // Paginação mantendo query string
    $produtos = $query->paginate(15)->withQueryString();

    return view('produtos.index', compact('produtos'));
}
    // FORM NOVO
    public function create()
    {
        return view('produtos.create', [
            'title' => 'Novo Produto'
        ]);
    }

    // SALVAR NOVO
    public function store(Request $request)
{
    $dados = $request->validate([
        'sku_interno'    => 'required|string|max:255',
        'nome'           => 'required|string|max:255',
        'codigo_barras'  => 'nullable|string|max:255',
        'peso'           => 'nullable|string|max:255',
        'altura'         => 'nullable|string|max:255',
        'largura'        => 'nullable|string|max:255',
        'comprimento'    => 'nullable|string|max:255',
    ]);

    // Produto base
    $produto = Produto::create($dados);

    // Variações (linhas adicionadas no formulário)
    if ($request->has('variacoes')) {
        foreach ($request->variacoes as $row) {
            // Ignorar linhas totalmente vazias
            if (
                empty($row['cor']) &&
                empty($row['tamanho']) &&
                empty($row['sku']) &&
                empty($row['estoque'])
            ) {
                continue;
            }

            ProdutoVariacao::create([
                'produto_id' => $produto->id,
                'cor'        => $row['cor'] ?? null,
                'tamanho'    => $row['tamanho'] ?? null,
                'sku'        => $row['sku'] ?? null,
                'estoque'    => (int)($row['estoque'] ?? 0),
            ]);
        }
    }

    return redirect()->route('produtos.index')
        ->with('success', 'Produto criado com sucesso!');
}
    // EDITAR
    public function edit($id)
    {
        $produto = Produto::findOrFail($id);

        return view('produtos.edit', [
            'title' => 'Editar Produto',
            'produto' => $produto
        ]);
    }

    // SALVAR EDIÇÃO
   public function update(Request $request, Produto $produto)
{
    $dados = $request->validate([
        'sku_interno'    => 'required|string|max:255',
        'nome'           => 'required|string|max:255',
        'codigo_barras'  => 'nullable|string|max:255',
        'peso'           => 'nullable|string|max:255',
        'altura'         => 'nullable|string|max:255',
        'largura'        => 'nullable|string|max:255',
        'comprimento'    => 'nullable|string|max:255',
    ]);

    $produto->update($dados);

    $idsMantidos = [];

    if ($request->has('variacoes')) {
        foreach ($request->variacoes as $row) {

            // Ignora linhas vazias totalmente
            if (
                empty($row['cor']) &&
                empty($row['tamanho']) &&
                empty($row['sku']) &&
                empty($row['estoque']) &&
                empty($row['id'] ?? null)
            ) {
                continue;
            }

            // Atualizar variação existente
            if (!empty($row['id'])) {
                $variacao = ProdutoVariacao::where('produto_id', $produto->id)
                    ->where('id', $row['id'])
                    ->first();

                if ($variacao) {
                    $variacao->update([
                        'cor'     => $row['cor'] ?? null,
                        'tamanho' => $row['tamanho'] ?? null,
                        'sku'     => $row['sku'] ?? null,
                        'estoque' => (int)($row['estoque'] ?? 0),
                    ]);

                    $idsMantidos[] = $variacao->id;
                }
            }
            // Criar nova variação
            else {
                $nova = ProdutoVariacao::create([
                    'produto_id' => $produto->id,
                    'cor'        => $row['cor'] ?? null,
                    'tamanho'    => $row['tamanho'] ?? null,
                    'sku'        => $row['sku'] ?? null,
                    'estoque'    => (int)($row['estoque'] ?? 0),
                ]);

                $idsMantidos[] = $nova->id;
            }
        }
    }

    // Remove variações que não vieram no formulário (e pertencem ao produto)
    if (!empty($idsMantidos)) {
        $produto->variacoes()
            ->whereNotIn('id', $idsMantidos)
            ->delete();
    } else {
        // Se não veio nada, apaga todas
        $produto->variacoes()->delete();
    }

    return redirect()->route('produtos.index')
        ->with('success', 'Produto atualizado com sucesso!');
}
    // DELETAR
    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído!');
    }

    public function show($id)
{
    $produto = Produto::findOrFail($id);

    return view('produtos.show', compact('produto'));
}


}

