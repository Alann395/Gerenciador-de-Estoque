@extends('layouts.app')

@section('content')

<div class="space-y-6 max-w-5xl mx-auto">

    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-red-400">
            Alertas de Estoque Baixo
        </h2>

        {{-- Removemos o botão voltar daqui --}}
    </div>

    <p class="text-gray-300">
        Mostrando itens abaixo do limite mínimo configurado.
    </p>

    <div class="rounded-lg border border-red-600 bg-red-900/10">

        @forelse ($produtosBaixoEstoque as $produto)

            <div class="border-b border-red-800 p-4">
                
                <h3 class="text-lg text-gray-200 font-semibold">
                  {{ $produto->sku_interno }} — {{ $produto->nome }} 
                </h3>

                <ul class="ml-4 mt-1 text-sm text-gray-300 list-disc">

                    @foreach ($produto->variacoes as $variacao)
                        
                        @if ($variacao->estoque < $limite)
                            <li>
                                {{ $produto->sku_interno }} — {{ $produto->nome }}
                                <span class="text-gray-400 text-sm">
                                ({{ $variacao->cor }} — {{ $variacao->tamanho }})
                                </span>
                                &nbsp;| Estoque:
                                <span class="text-red-400 font-bold">{{ $variacao->estoque }}</span>
                            </li>
                        @endif

                    @endforeach

                </ul>
            </div>

        @empty

            <div class="p-8 text-center">
                🎉 <span class="text-gray-300">Nenhum produto com estoque baixo!</span>
            </div>

        @endforelse

    </div>

</div>

@endsection
