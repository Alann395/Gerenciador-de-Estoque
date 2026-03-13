@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <h2 class="text-2xl font-semibold text-blue-400">Usuários do Sistema</h2>

    <a href="{{ route('users.create') }}"
       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white inline-block">
        + Novo Usuário
    </a>

    <table class="w-full mt-6 border-collapse border border-gray-700 text-gray-300">
        <thead class="bg-gray-800">
            <tr>
                <th class="border border-gray-700 px-3 py-2">ID</th>
                <th class="border border-gray-700 px-3 py-2">Nome</th>
                <th class="border border-gray-700 px-3 py-2">Categoria</th>
                <th class="border border-gray-700 px-3 py-2">Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
               <tr class="border-b border-gray-700">
    <td class="py-2 px-3 text-gray-300">{{ $user->name }}</td>
    <td class="py-2 px-3 text-gray-300">{{ $user->email }}</td>
    <td class="py-2 px-3 text-gray-300 capitalize">{{ $user->role }}</td>

    <td class="py-2 px-3 flex gap-2">

        <a href="{{ route('users.edit', $user->id) }}"
           class="px-3 py-1 text-xs bg-blue-600 hover:bg-blue-700 rounded text-white">
            Editar
        </a>

        <button type="button"
        onclick="abrirModalExcluir({{ $user->id }}, '{{ $user->name }}')"
        class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-xs font-semibold transition">
            Excluir
        </button>

        </td>
    </tr>

     @endforeach
    </tbody>

   <!-- MODAL DE EXCLUSÃO -->
    <div id="modalExcluir" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div class="bg-[#0d1117] border border-red-600/60 rounded-lg p-6 w-[90%] max-w-md shadow-xl shadow-red-500/30">

        <h2 class="text-lg font-semibold text-red-400 mb-4">
            ⚠ Confirmar exclusão
        </h2>

        <p id="modalTexto" class="text-gray-300 mb-6"></p>

        <form id="formExcluir" method="POST" action="">
            @csrf
            @method('DELETE')

            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="fecharModalExcluir()"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Cancelar
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 border border-red-400 shadow-lg shadow-red-500/30 transition">
                    Sim, excluir
                </button>
            </div>
        </form>

    </div>
</div>
@section('scripts')
<script>
let modal = document.getElementById('modalExcluir');
let modalTexto = document.getElementById('modalTexto');
let formExcluir = document.getElementById('formExcluir');

function abrirModalExcluir(id, nome) {
    modal.classList.remove('hidden');
    modalTexto.innerHTML = `
        Tem certeza que deseja excluir o usuário
        <span class="text-red-400 font-bold">"${nome}"</span>?
        <br><small class="text-gray-400">Esta ação não poderá ser desfeita.</small>
    `;
    formExcluir.action = `/usuarios/${id}`;
}

function fecharModalExcluir() {
    modal.classList.add('hidden');
}
</script>
@endsection



</div>
@endsection
