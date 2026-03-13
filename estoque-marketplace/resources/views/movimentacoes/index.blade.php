@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-200">
        Histórico de Movimentações
    </h2>

    {{-- FILTRO ANTIGO (COM DIA, MÊS e HORA) --}}
    <form method="GET" class="bg-[#11151d] border border-gray-700 p-5 rounded-lg flex gap-8 flex-wrap">

        <div>
            <label class="block text-gray-300 text-sm mb-1">Dia</label>
            <input type="date" name="dia" value="{{ request('dia') }}"
                class="bg-[#0d1117] px-3 py-2 rounded border border-gray-600 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-48">
        </div>

        <div>
            <label class="block text-gray-300 text-sm mb-1">Mês</label>
            <input type="month" name="mes" value="{{ request('mes') }}"
                class="bg-[#0d1117] px-3 py-2 rounded border border-gray-600 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-48">
        </div>

        <div>
            <label class="block text-gray-300 text-sm mb-1">Hora</label>
            <input type="time" name="hora" value="{{ request('hora') }}"
                class="bg-[#0d1117] px-3 py-2 rounded border border-gray-600 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-48">
        </div>

        <div class="flex items-end">
            <button
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-md shadow-md shadow-blue-400/30 transition">
                Filtrar
            </button>
        </div>

    </form>

    {{-- LISTAGEM --}}
    <div class="rounded-lg bg-[#11151d] border border-gray-700 overflow-hidden">

        <table class="w-full text-left text-gray-300">
            <thead class="bg-[#1a1f27]">
                <tr>
                    <th class="p-3">Produto</th>
                    <th class="p-3">Variação</th>
                    <th class="p-3">Tipo</th>
                    <th class="p-3">Qtd</th>
                    <th class="p-3">Motivo</th>
                    <th class="p-3">Data</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($movimentacoes as $m)
                    <tr class="border-b border-gray-800 hover:bg-[#1a1f27]">

                        <td class="p-3">
                            {{ $m->variacao->produto->nome ?? '-' }}
                        </td>

                        <td class="p-3">
                            {{ ($m->variacao->cor ?? '-') . ' ' . ($m->variacao->tamanho ?? '-') }}
                        </td>

                        <td class="p-3">
                            @if($m->tipo === 'entrada')
                                <span class="text-green-400 font-semibold">Entrada</span>
                            @else
                                <span class="text-red-400 font-semibold">Saída</span>
                            @endif
                        </td>

                        <td class="p-3 font-semibold">{{ $m->quantidade }}</td>
                        <td class="p-3">{{ $m->motivo ?? '-' }}</td>

                        <td class="p-3 text-gray-400 text-sm">
                            {{ $m->created_at->format('d/m/Y H:i') }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">
                            Nenhuma movimentação encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        <div class="p-4">
            {{ $movimentacoes->links() }}
        </div>
    </div>

</div>
@endsection
