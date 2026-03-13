<x-guest-layout>

    <!-- Logo + Nome -->
    <div class="flex flex-col items-center mb-6">
        <img src="/images/fs-logo.png" class="w-16 h-16" alt="Logo FS">
        <h1 class="text-2xl font-bold text-gray-200 mt-3">
            FS Estoque Inteligente
        </h1>
    </div>

    <div class="mb-4 text-sm text-gray-400 text-center">
        Bem-vindo de volta
    </div>

    <!-- Formulário -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-gray-300 mb-1">Email</label>
            <input id="email" 
                class="w-full p-2 rounded bg-[#0f141b] border border-gray-600 text-white
                       focus:border-blue-500 focus:ring focus:ring-blue-500/30 transition"
                type="email" 
                name="email" 
                required autofocus />
        </div>

        <!-- Senha -->
        <div class="mt-4">
            <label for="password" class="block text-gray-300 mb-1">Senha</label>
            <input id="password" 
                class="w-full p-2 rounded bg-[#0f141b] border border-gray-600 text-white
                       focus:border-blue-500 focus:ring focus:ring-blue-500/30 transition"
                type="password" 
                name="password" 
                required />
        </div>

        <!-- Checkbox -->
        <div class="mt-4 flex items-center">
            <input id="remember_me" 
                   type="checkbox" 
                   class="rounded border-gray-500 bg-gray-700 text-blue-500"
                   name="remember">

            <label for="remember_me" class="ml-2 text-gray-300">
                Lembrar de mim
            </label>
        </div>

        <!-- Botão -->
        <div class="mt-6 flex items-center justify-center">
            <button 
                class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Entrar
            </button>
        </div>
       

        <!-- Esqueceu senha -->
        <div class="mt-4 text-center">
            <a class="text-blue-400 hover:underline" href="{{ route('password.request') }}">
                Esqueceu sua senha?
            </a>
        </div>

    </form>

</x-guest-layout>
