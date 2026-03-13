@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <h2 class="text-2xl font-semibold text-gray-200">Painel Geral</h2>

    
   {{-- ALERTA DE ESTOQUE BAIXO (somente ADM) --}}
    @if(auth()->user()->role === 'admin')
    @if (!empty($totalAlertas) && $totalAlertas > 0)
        <div class="p-4 rounded-lg border border-red-500 bg-red-600/20 shadow-md">

            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-red-400">
                    ⚠ Atenção — Existem itens com estoque baixo!
                </h3>

                <a href="{{ route('estoque.alertas') }}"
                   class="text-xs px-3 py-1 bg-red-500 hover:bg-red-600 transition rounded text-white font-semibold">
                    Ver detalhes
                </a>
            </div>

            <p class="text-gray-300 font-semibold mb-2">
                Existem
                <span class="text-red-400 font-bold">{{ $totalAlertas }}</span>
                variação(ões) com estoque abaixo de
                <span class="font-bold">{{ $limite }}</span> unidades.
            </p>

            </div>
        @endif
    @endif


    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- CARD — PRODUTOS (somente ADM) --}}
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('produtos.index') }}"
           class="block p-6 rounded-lg bg-[#0f131a] border border-gray-700 hover:border-blue-500 
                  hover:bg-blue-500/10 transition shadow">

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-200">Produtos</h3>
                <i data-lucide="box" class="w-8 h-8 text-blue-400"></i>
            </div>

            <p class="text-gray-400 text-sm">
                Cadastre, edite e controle variações e estoque.
            </p>
        </a>
        @endif


        {{-- ENTRADA --}}
        <a href="{{ route('estoque.index') }}?tipo=entrada"
           class="block p-6 rounded-lg bg-[#0f131a] border border-gray-700 hover:border-green-500 
                  hover:bg-green-500/10 transition shadow">

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-200">Entrada de Estoque</h3>
                <i data-lucide="arrow-down-circle" class="w-8 h-8 text-green-400"></i>
            </div>

            <p class="text-gray-400 text-sm">
                Entrada manual de itens no estoque.
            </p>
        </a>


        {{-- SAÍDA --}}
        <a href="{{ route('estoque.index') }}?tipo=saida"
           class="block p-6 rounded-lg bg-[#0f131a] border border-gray-700 hover:border-yellow-500 
                  hover:bg-yellow-500/10 transition shadow">

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-200">Saída de Estoque</h3>
                <i data-lucide="arrow-up-circle" class="w-8 h-8 text-yellow-400"></i>
            </div>

            <p class="text-gray-400 text-sm">
                Saída manual de itens no estoque.
            </p>
        </a>


        {{-- CARD — MOVIMENTAÇÕES (somente ADM) --}}
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('movimentacoes.index') }}"
           class="block p-6 rounded-lg bg-[#0f131a] border border-gray-700 hover:border-blue-500 
                  hover:bg-blue-500/10 transition shadow">

            <div class="flex items-center justify-between mb-4 gap-6">
                <h3 class="text-xl font-semibold text-gray-200">Movimentações</h3>

                <div class="flex items-center justify-center w-10 h-10">
                    <i data-lucide="repeat" class="w-8 h-8 text-blue-400"></i>
                </div>
            </div>

            <p class="text-gray-400 text-sm">
                Histórico de entradas e saídas de estoque.
            </p>
        </a>
        @endif

    </div>
</div>

@endsection
