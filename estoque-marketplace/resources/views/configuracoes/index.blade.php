@extends('layouts.app')

@section('content')

<div class="max-w-lg mx-auto bg-[#0f131a] border border-gray-700 p-6 rounded-lg">

    <h2 class="text-2xl font-semibold text-gray-200 mb-4">Configurações do Sistema</h2>

    @if(session('success'))
        <div class="p-3 bg-green-700 text-white rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('configuracoes.update') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-300 font-medium">Quantidade mínima para alerta</label>

            <input
              type="number"
              name="limite"
              class="bg-[#0d1117] border border-gray-600 text-white px-4 py-3 rounded-lg w-full"
              value="{{ $limite }}"
            >

        </div>

        <button class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-700 text-white">
            Salvar Configuração
        </button>

    </form>
        @if(auth()->user()->role === 'admin')
    <div class="mt-10 p-5 bg-gray-900 rounded border border-blue-600/40 shadow">

        <h3 class="text-xl text-blue-400 font-semibold mb-3">
            Gestão de Usuários
        </h3>

        <p class="text-gray-300 text-sm mb-4">
            Aqui você pode criar novos usuários e definir o acesso ao sistema.
        </p>

        <a href="{{ route('users.index') }}"
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white inline-block transition">
            Gerenciar Usuários
        </a>

    </div>
@endif

</div>

@endsection

