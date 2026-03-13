@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto space-y-6">

    <h2 class="text-xl font-semibold text-blue-400">Criar Novo Usuário</h2>

    @if ($errors->any())
        <div class="bg-red-600/30 text-red-300 p-3 rounded">
            <ul class="text-sm">
                @foreach ($errors->all() as $erro)
                    <li>• {{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
        @csrf

        <label class="block">
            <span class="text-gray-300">Nome:</span>
            <input type="text" name="name" class="w-full rounded p-2 bg-gray-900 text-gray-100">
        </label>

        <label class="block">
            <span class="text-gray-300">Email:</span>
            <input type="email" name="email" class="w-full rounded p-2 bg-gray-900 text-gray-100">
        </label>

        <label class="block">
            <span class="text-gray-300">Função:</span>
            <select name="role" class="w-full rounded p-2 bg-gray-900 text-gray-100">
                <option value="admin">Administrador</option>
                <option value="colaborador">Colaborador</option>
            </select>
        </label>

        <label class="block">
            <span class="text-gray-300">Senha:</span>
            <input type="password" name="password" class="w-full rounded p-2 bg-gray-900 text-gray-100">
        </label>

        <button class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded text-white">
            Salvar
        </button>

    </form>

</div>
@endsection
