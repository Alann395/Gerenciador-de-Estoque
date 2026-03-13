@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-200 mb-4">
        Ajustes de Estoque
    </h2>

    <div class="bg-[#0f131a] border border-gray-700 rounded-lg p-6 formulario-estoque">

        {{-- MENSAGEM DE SUCESSO --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-2 rounded bg-emerald-600/20 border border-emerald-500 text-emerald-200 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROS --}}
        @if ($errors->any())
            <div class="mb-4 px-4 py-2 rounded bg-red-600/20 border border-red-500 text-red-200 text-sm">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('estoque.movimentar') }}">
            @csrf

            {{-- PRODUTO E VARIAÇÃO --}}
            <div class="mb-4">
                <label class="block text-gray-300 mb-1">
                    Produto e Variação
                </label>

                <div id="select-wrapper">
                    <select name="variacao_id"
                            id="variacao_id"
                            style="width: 100%;">
                    </select>
                </div>
            </div>

            {{-- TIPO --}}
            @php
                $tipoSelecionado = old('tipo', request('tipo'));
            @endphp

            <div class="mb-4">
                <label class="block text-gray-300 mb-1">Tipo</label>

                <select name="tipo"
                        class="w-full p-2 rounded bg-[#0d1117] border border-gray-700 text-white"
                        required>
                    <option value="" disabled {{ !$tipoSelecionado ? 'selected' : '' }}>Selecione...</option>
                    <option value="entrada" {{ $tipoSelecionado === 'entrada' ? 'selected' : '' }}>Entrada (+)</option>
                    <option value="saida" {{ $tipoSelecionado === 'saida' ? 'selected' : '' }}>Saída (-)</option>
                </select>
            </div>

            {{-- QUANTIDADE --}}
            <div class="mb-4">
                <label class="block text-gray-300 mb-1">Quantidade</label>
                <input type="number" min="1" name="quantidade" value="{{ old('quantidade') }}"
                       class="w-full p-2 rounded bg-[#0d1117] border border-gray-700 text-white">
            </div>

            {{-- MOTIVO --}}
            <div class="mb-6">
                <label class="block text-gray-300 mb-1">Motivo (opcional)</label>
                <input type="text" name="motivo"
                       value="{{ old('motivo') }}"
                       placeholder="Ex: ajuste manual, devolução..."
                       class="w-full p-2 rounded bg-[#0d1117] border border-gray-700 text-white">
            </div>

            <div class="flex justify-end">
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Salvar Movimentação
                </button>
            </div>

        </form>
    </div>
</div>
@endsection


{{-- SCRIPTS SELECT2 DARK --}}
@section('scripts')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
.select2-dropdown {
    background: #111827 !important;
    border: 1px solid #374151 !important;
}

.select2-container .select2-selection--single {
    background: #0d1117 !important;
    border: 1px solid #374151 !important;
    height: 45px !important;
    display: flex;
    align-items: center;
}

.select2-selection__rendered {
    color: white !important;
    line-height: 45px !important;
    padding-left: 10px !important;
}

.select2-selection__arrow {
    margin-top: 6px !important;
}

.select2-results__option {
    color: white !important;
    padding: 10px !important;
}

.select2-results__option--highlighted {
    background: rgba(59,130,246,0.5) !important;
}
/* Input onde digita dentro do dropdown */
.select2-container .select2-search__field {
    background-color: #0d1117 !important;
    color: white !important;
    border: 1px solid #374151 !important;
    padding: 6px 10px !important;
}

.select2-search--dropdown {
    background-color: #0d1117 !important;
}

</style>

<script>
$(document).ready(function () {

    $('#variacao_id').select2({
        placeholder: "Digite para buscar...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#select-wrapper'),

        minimumInputLength: 1,

        ajax: {
            url: "{{ route('buscar.variacoes') }}",
            dataType: 'json',
            delay: 250,
            data: params => ({ search: params.term }),
            processResults: data => ({ results: data.results })
        }
    });

});
</script>

@endsection
