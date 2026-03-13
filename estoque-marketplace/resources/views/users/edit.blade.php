@extends('layouts.app')

@section('content')

<div class="max-w-lg mx-auto bg-gray-900 p-6 rounded border border-blue-600/40 shadow">

    <h2 class="text-xl font-semibold text-blue-400 mb-5">Editar Usuário</h2>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block text-gray-300 text-sm font-medium">Nome</label>
        <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-gray-800 text-gray-200 p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-300 text-sm font-medium">E-mail</label>
        <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-gray-800 text-gray-200 p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-300 text-sm font-medium">Função</label>
        <select name="role" class="w-full bg-gray-800 text-gray-200 p-2 rounded">
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
            <option value="colaborador" {{ $user->role == 'colaborador' ? 'selected' : '' }}>Colaborador</option>
        </select>
    </div>

    <hr class="border-blue-600/40 my-6">

    <p class="text-blue-400 font-semibold">Alterar senha</p>

    <div class="mb-4 mt-2">
        <label class="block text-gray-300 text-sm font-medium">Nova senha</label>
        <input type="password" name="password" class="w-full bg-gray-800 text-gray-200 p-2 rounded" placeholder="Deixe vazio para não alterar">
    </div>

    <div class="flex justify-between mt-6">
        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded text-white">
            Cancelar
        </a>

        <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white">
            Salvar Alterações
        </button>
    </div>
</form>


</div>

@endsection
