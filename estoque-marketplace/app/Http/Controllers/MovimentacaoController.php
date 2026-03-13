<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use Illuminate\Http\Request;

class MovimentacaoController extends Controller
{
    public function index(Request $request)
    {
        // Inicia a query
        $query = Movimentacao::with('variacao.produto');

        // FILTRO POR PERÍODOS
        if ($request->periodo === 'hora') {
            $query->where('created_at', '>=', now()->subHour());
        }

        if ($request->periodo === 'dia') {
            $query->whereDate('created_at', now()->format('Y-m-d'));
        }

        if ($request->periodo === 'mes') {
            $query->whereMonth('created_at', now()->format('m'));
        }

        // Ordenação e paginação
        $movimentacoes = $query->latest()->paginate(20);

        return view('movimentacoes.index', compact('movimentacoes'));
    }
}
