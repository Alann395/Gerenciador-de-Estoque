@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <h2 class="text-2xl font-semibold text-red-400">
        Alertas de Estoque Baixo
    </h2>

    <p class="text-sm text-gray-400">
        Mostrando itens abaixo do limite mínimo configurado.
    </p>

    <div class="bg-[#0f131a] border border-red-600/40 rounded-lg shadow p-6">

        @forelse ($produtos as $produto)

            <div class="mb-6 p-4 rounded-lg bg-[#1a1f27] border border-gray-700">
                <h3 class="text-lg font-semibold text-gray-200 mb-2">
                    {{ $produto->nome }}
                </h3>

                <table class="w-full text-left text-gray-300 text-sm border-t border-gray-700">
                    @foreach ($produto->variacoes as $v)
                        @if ($v->estoque < $limite)
                        <tr class="border-b border-gray-800">
                            <td class="p-2">
                                {{ $v->cor ?? '-' }} {{ $v->tamanho ?? '-' }}
                            </td>
                            <td class="p-2 text-red-400 font-bold">
                                Estoque: {{ $v->estoque }}
                            </td>

                            <td class="p-2">
                                <a href="{{ route('produtos.edit', $produto->id) }}"
                                   class="px-3 py-1 bg-blue-600 hover:bg-blue-700 rounded text-white text-xs">
                                    Repor Estoque
                                </a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </table>
            </div>

        @empty
            <div class="text-center text-gray-400 py-6">
                🎉 Nenhum produto com estoque baixo!
            </div>
        @endforelse

    </div>
</div>
@endsection
