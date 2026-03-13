@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        <h2 class="text-2xl font-semibold text-gray-200 mb-4">Editar Produto</h2>

        <div class="bg-[#0f131a] border border-gray-700 shadow sm:rounded-lg p-6">

            <form method="POST" action="{{ route('produtos.update', $produto->id) }}">
                @csrf
                @method('PUT')

                {{-- DADOS BÁSICOS --}}
                <div class="mb-4">
                    <label class="block text-gray-300">SKU Interno</label>
                    <input type="text" name="sku_interno" value="{{ $produto->sku_interno }}"
                           class="w-full p-2 rounded bg-[#0d1117] border border-gray-700 text-white"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300">Nome</label>
                    <input type="text" name="nome" value="{{ $produto->nome }}"
                           class="w-full p-2 rounded bg-[#0d1117] border border-gray-700 text-white"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300">Código de Barras</label>
                    <input type="text" name="codigo_barras" value="{{ $produto->codigo_barras }}"
                           class="w-full p-2 rounded bg-[#0d1117] border border-gray-700 text-white">
                </div>

                {{-- MEDIDAS COM UNIDADES --}}
                <div class="grid grid-cols-2 gap-4 mb-4">

                    <div>
                        <label class="block text-gray-300">Peso (kg)</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="peso" value="{{ $produto->peso }}"
                                   class="w-full p-2 pr-12 rounded bg-[#0d1117] border border-gray-700 text-white">
                            <span class="absolute right-3 top-2.5 text-gray-400 text-sm">kg</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-300">Altura (cm)</label>
                        <div class="relative">
                            <input type="number" step="0.1" name="altura" value="{{ $produto->altura }}"
                                   class="w-full p-2 pr-12 rounded bg-[#0d1117] border border-gray-700 text-white">
                            <span class="absolute right-3 top-2.5 text-gray-400 text-sm">cm</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-300">Largura (cm)</label>
                        <div class="relative">
                            <input type="number" step="0.1" name="largura" value="{{ $produto->largura }}"
                                   class="w-full p-2 pr-12 rounded bg-[#0d1117] border border-gray-700 text-white">
                            <span class="absolute right-3 top-2.5 text-gray-400 text-sm">cm</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-300">Comprimento (cm)</label>
                        <div class="relative">
                            <input type="number" step="0.1" name="comprimento" value="{{ $produto->comprimento }}"
                                   class="w-full p-2 pr-12 rounded bg-[#0d1117] border border-gray-700 text-white">
                            <span class="absolute right-3 top-2.5 text-gray-400 text-sm">cm</span>
                        </div>
                    </div>

                </div>

                {{-- VARIAÇÕES --}}
                <hr class="border-gray-700 my-6">

                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-200">Variações (Cor / Tamanho)</h3>
                    <button type="button"
                            onclick="adicionarVariacao()"
                            class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                        + Adicionar variação
                    </button>
                </div>

                <div id="variacoes-wrapper" class="space-y-3">
                    @php $index = 0; @endphp

                    @foreach ($produto->variacoes as $variacao)
                    <div class="grid grid-cols-4 gap-3 variacao-row">
                        <input type="hidden" name="variacoes[{{ $index }}][id]" value="{{ $variacao->id }}">

                        <input type="text" name="variacoes[{{ $index }}][cor]"
                               value="{{ $variacao->cor }}" placeholder="Cor"
                               class="p-2 rounded bg-[#0d1117] border border-gray-700 text-white">

                        <input type="text" name="variacoes[{{ $index }}][tamanho]"
                               value="{{ $variacao->tamanho }}" placeholder="Tamanho"
                               class="p-2 rounded bg-[#0d1117] border border-gray-700 text-white">

                        <input type="text" name="variacoes[{{ $index }}][sku]"
                               value="{{ $variacao->sku }}" placeholder="SKU variação"
                               class="p-2 rounded bg-[#0d1117] border border-gray-700 text-white">

                        <input type="number" name="variacoes[{{ $index }}][estoque]"
                               value="{{ $variacao->estoque }}" placeholder="Estoque"
                               class="p-2 rounded bg-[#0d1117] border border-gray-700 text-white">
                    </div>

                    @php $index++; @endphp
                    @endforeach
                </div>

                {{-- BOTÕES --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('produtos.index') }}"
                       class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        Cancelar
                    </a>

                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Salvar
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- SCRIPT VARIAÇÕES --}}
<script>
    let variacaoIndex = {{ $index ?? 0 }};

    function adicionarVariacao() {
        const wrapper = document.getElementById('variacoes-wrapper');

        const row = document.createElement('div');
        row.className = 'grid grid-cols-4 gap-3 variacao-row';

        row.innerHTML = `
            <input type="text" name="variacoes[${variacaoIndex}][cor]"
                   placeholder="Cor"
                   class="p-2 rounded bg-[#0d1117] border border-gray-700 text-white">

            <input type="text" name="variacoes[${variacaoIndex}][tamanho]"
                   placeholder="Tamanho"
                   class="p-2 rounded bg-[#0d1117] border border-gray-700 text-white">

            <input type="text" name="variacoes[${variacaoIndex}][sku]"
                   placeholder="SKU variação"
                   class="p-2 rounded bg-[#0d1117] border border-gray-700 text-white">

            <input type="number" name="variacoes[${variacaoIndex}][estoque]"
                   placeholder="Estoque"
                   class="p-2 rounded bg-[#0d1117] border border-gray-700 text-white">
        `;

        wrapper.appendChild(row);
        variacaoIndex++;
    }
</script>

@endsection
