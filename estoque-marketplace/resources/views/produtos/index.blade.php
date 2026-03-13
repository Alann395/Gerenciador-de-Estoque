@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-200">Produtos</h1>

        <a href="{{ route('produtos.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + Novo Produto
        </a>
    </div>

    <div class="rounded-lg bg-[#11151d] border border-gray-700 overflow-hidden">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-[#1a1f27] text-gray-200">
                <tr>
                    <th class="p-3"></th>
                    <th class="p-3">SKU</th>
                    <th class="p-3">Nome</th>
                    <th class="p-3">Estoque</th>
                    <th class="p-3 w-32">Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($produtos as $produto)
                    {{-- LINHA PRINCIPAL --}}
                    <tr class="border-b border-gray-700 hover:bg-[#1a1f27] cursor-pointer"
                        onclick="toggleVariações({{ $produto->id }})">

                        <td class="p-3 w-10 text-center">
                            <span id="seta-{{ $produto->id }}" class="transition-transform">▶</span>
                        </td>

                        <td class="p-3">{{ $produto->sku_interno }}</td>
                        <td class="p-3">{{ $produto->nome }}</td>

                        <td class="p-3 font-semibold text-green-400">
                            {{ $produto->estoqueTotal() }}
                        </td>

                        <td class="p-3 flex gap-2">

                            <a href="{{ route('produtos.edit', $produto->id) }}"
                               class="px-3 py-1 bg-yellow-500 text-black rounded hover:bg-yellow-600 text-sm">
                                Editar
                            </a>

                            <form method="POST" action="{{ route('produtos.destroy', $produto->id) }}">
                                @csrf
                                @method('DELETE')
                                <button
                                   class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm"
                                   onclick="return confirm('Tem certeza?')">
                                    Excluir
                                </button>
                            </form>

                        </td>
                    </tr>

                    {{-- LINHA OCULTA DAS VARIAÇÕES --}}
                    <tr id="variacoes-{{ $produto->id }}" class="hidden bg-[#0d1117]">
                        <td colspan="5" class="p-4">

                            @if ($produto->variacoes->count() > 0)
                                <table class="w-full text-sm border border-gray-700 rounded overflow-hidden">
                                    <thead class="bg-[#1a1f27] text-gray-300">
                                        <tr>
                                            <th class="p-2">Cor</th>
                                            <th class="p-2">Tamanho</th>
                                            <th class="p-2">SKU</th>
                                            <th class="p-2">Estoque</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($produto->variacoes as $v)
                                            <tr class="border-b border-gray-700">
                                                <td class="p-2">{{ $v->cor }}</td>
                                                <td class="p-2">{{ $v->tamanho }}</td>
                                                <td class="p-2">{{ $v->sku }}</td>
                                                <td class="p-2 text-green-400">{{ $v->estoque }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            @else
                                <p class="text-gray-400 text-sm">Nenhuma variação cadastrada.</p>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

{{-- JAVASCRIPT --}}
<script>
function toggleVariações(id) {
    let linha = document.getElementById('variacoes-' + id);
    let seta = document.getElementById('seta-' + id);

    if (linha.classList.contains('hidden')) {
        linha.classList.remove('hidden');
        seta.style.transform = "rotate(90deg)";
    } else {
        linha.classList.add('hidden');
        seta.style.transform = "rotate(0deg)";
    }
}
</script>

@endsection
