<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Detalhes do Produto
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-[#0f131a] border border-gray-700 shadow sm:rounded-lg p-6">

                {{-- TÍTULO + BOTÃO EDITAR --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-semibold text-gray-200">
                        {{ $produto->nome }}
                    </h3>

                    <a href="{{ route('produtos.edit', $produto->id) }}"
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                        Editar Produto
                    </a>
                </div>

                {{-- INFORMAÇÕES BÁSICAS --}}
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-300 mb-2">Informações Gerais</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="p-4 bg-[#11161e] rounded border border-gray-700">
                            <span class="text-gray-400">SKU Interno:</span>
                            <p class="text-gray-200 font-medium">{{ $produto->sku_interno }}</p>
                        </div>

                        <div class="p-4 bg-[#11161e] rounded border border-gray-700">
                            <span class="text-gray-400">Código de Barras:</span>
                            <p class="text-gray-200 font-medium">{{ $produto->codigo_barras ?? '-' }}</p>
                        </div>

                        <div class="p-4 bg-[#11161e] rounded border border-gray-700">
                            <span class="text-gray-400">Ativo:</span>
                            <p class="text-gray-200 font-medium">
                                {{ $produto->ativo ? 'Sim' : 'Não' }}
                            </p>
                        </div>

                    </div>
                </div>

                {{-- MEDIDAS --}}
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-300 mb-2">Dimensões & Peso</h4>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                        <div class="p-4 bg-[#11161e] rounded border border-gray-700">
                            <span class="text-gray-400">Peso (kg):</span>
                            <p class="text-gray-200 font-medium">{{ $produto->peso ?? '-' }}</p>
                        </div>

                        <div class="p-4 bg-[#11161e] rounded border border-gray-700">
                            <span class="text-gray-400">Altura (cm):</span>
                            <p class="text-gray-200 font-medium">{{ $produto->altura ?? '-' }}</p>
                        </div>

                        <div class="p-4 bg-[#11161e] rounded border border-gray-700">
                            <span class="text-gray-400">Largura (cm):</span>
                            <p class="text-gray-200 font-medium">{{ $produto->largura ?? '-' }}</p>
                        </div>

                        <div class="p-4 bg-[#11161e] rounded border border-gray-700">
                            <span class="text-gray-400">Comprimento (cm):</span>
                            <p class="text-gray-200 font-medium">{{ $produto->comprimento ?? '-' }}</p>
                        </div>

                    </div>
                </div>

                {{-- BOTÃO VOLTAR --}}
                <div class="flex justify-end mt-4">
                    <a href="{{ route('produtos.index') }}"
                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded transition">
                        Voltar
                    </a>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
