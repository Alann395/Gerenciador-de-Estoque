<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ÍCONES LUCIDE --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });
    </script>
</head>

<body class="bg-[#0d1117] text-gray-100">
@php
    use App\Models\Produto;

    // MESMA REGRA DA ABA ALERTAS
    $limiteAlerta = env('ESTOQUE_MINIMO', 10);

    $produtosBaixoEstoqueHeader = Produto::whereHas('variacoes', function($q) use ($limiteAlerta) {
        $q->where('estoque', '<', $limiteAlerta);
    })->with(['variacoes' => function($q) use ($limiteAlerta) {
        $q->where('estoque', '<', $limiteAlerta);
    }])->get();

    // total de variações com estoque baixo
    $totalAlertasHeader = $produtosBaixoEstoqueHeader->sum(function($p) {
        return $p->variacoes->count();
    });
@endphp

<div class="flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 h-screen bg-[#0b0f14] border-r border-blue-600/40 shadow-lg shadow-blue-600/20 relative">

        <div class="p-6 flex items-center gap-3">
            <img src="/images/fs-logo.png" class="w-10 h-10 object-contain drop-shadow-lg" alt="Logo FS">
            <span class="text-xl font-bold text-blue-400 drop-shadow-lg">FS Estoque Inteligente</span>
        </div>

        <nav class="mt-6 space-y-2 px-4">

    {{-- MENU PARA ADMIN --}}
    @if(auth()->user()->role === 'admin')

        <a href="/dashboard" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-600/20 transition">
            <i data-lucide="home" class="w-5 h-5 text-blue-400"></i> Início
        </a>

        <a href="/produtos" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-600/20 transition">
            <i data-lucide="box" class="w-5 h-5 text-blue-400"></i> Produtos
        </a>

        <a href="/movimentacoes" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-600/20 transition">
            <i data-lucide="repeat" class="w-5 h-5 text-blue-400"></i> Movimentações
        </a>

        <a href="/configuracoes" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-600/20 transition">
            <i data-lucide="settings" class="w-5 h-5 text-blue-400"></i> Configurações
        </a>

        <a href="{{ route('estoque.alertas') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-red-600/20 transition">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-400"></i> Alertas de Estoque
        </a>

    @endif


    {{-- MENU PARA COLABORADOR --}}
    @if(auth()->user()->role === 'colaborador')

        <a href="/ajuste-estoque?tipo=entrada" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-green-600/20 transition">
            <i data-lucide="arrow-down-circle" class="w-5 h-5 text-green-400"></i> Entrada de Estoque
        </a>

        <a href="/ajuste-estoque?tipo=saida" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-yellow-600/20 transition">
            <i data-lucide="arrow-up-circle" class="w-5 h-5 text-yellow-400"></i> Saída de Estoque
        </a>

    @endif


    {{-- MENU COMUM A TODOS --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button 
            class="w-full flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-red-600/20 transition text-red-400 font-semibold text-left">
            <i data-lucide="log-out" class="w-5 h-5 text-red-400"></i> Sair
        </button>
    </form>

</nav>

        {{-- LINHA NEON --}}
        <div class="absolute right-0 top-0 w-[3px] h-full bg-gradient-to-b from-blue-500 to-blue-300 shadow-blue-400 shadow-[0_0_15px]"></div>

    </aside>

    {{-- CONTEÚDO PRINCIPAL --}}
    <main class="flex-1">

        {{-- HEADER --}}
        <header class="w-full backdrop-blur-md bg-white/5 border-b border-blue-600/20 p-4 flex items-center justify-between">

            <h1 class="text-2xl font-semibold text-blue-400">{{ $title ?? 'Dashboard' }}</h1>

            <div class="flex items-center gap-4">

{{-- 🔔 SININHO DE NOTIFICAÇÕES — SOMENTE ADMIN --}}
@auth
    @if(auth()->user()->role === 'admin')
        <div class="relative">
            <button id="btn-bell"
                    type="button"
                    class="relative flex items-center justify-center w-10 h-10 rounded-full 
                           hover:bg-blue-500/20 transition">
                <i data-lucide="bell" class="w-5 h-5 text-blue-300"></i>

                @if($totalAlertasHeader > 0)
                    <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1
                                 bg-red-500 text-[11px] text-white rounded-full 
                                 flex items-center justify-center font-bold">
                        {{ $totalAlertasHeader }}
                    </span>
                @endif
            </button>

            {{-- DROPDOWN --}}
            <div id="notifications-dropdown"
                class="hidden absolute right-0 mt-2 w-80 bg-[#05070c] border border-gray-700 
                        rounded-lg shadow-xl z-50">

                <div class="px-4 py-2 border-b border-gray-700 text-sm font-semibold text-gray-200">
                    Notificações
                </div>

                <div class="max-h-64 overflow-y-auto text-sm">

                    @if($totalAlertasHeader > 0)
                        <a href="{{ route('estoque.alertas') }}"
                           class="flex items-start gap-2 px-4 py-3 hover:bg-[#111827] transition">

                            <i data-lucide="alert-triangle" class="w-4 h-4 text-red-400 mt-0.5"></i>

                            <div class="text-gray-300">
                                <div class="font-semibold text-red-400">
                                    {{ $totalAlertasHeader }} variação(ões) com estoque baixo
                                </div>

                                <div class="mt-1 text-gray-400">
                                    Um ou mais produtos estão com estoque abaixo de {{ $limiteAlerta }} unidades.
                                    Clique para ver detalhes.
                                </div>
                            </div>
                        </a>
                    @else
                        <div class="px-4 py-3 text-gray-400">
                            Nenhuma notificação no momento.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endif
@endauth

                {{-- NOME / USUÁRIO --}}
                <div class="flex items-center gap-3">
                    <span class="font-medium text-gray-200">Admin</span>

                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center font-bold shadow-lg shadow-blue-400">
                        {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
                    </div>
                </div>

            </div>
        </header>

        {{-- BOTÃO VOLTAR AUTOMÁTICO --}}
        @if (!request()->is('dashboard'))
            <div class="px-6 pt-4 flex justify-end">
                <a href="/dashboard"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-500/20 border border-blue-500/40 
                          text-blue-300 hover:bg-blue-500/30 transition shadow-blue-neon">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    Voltar
                </a>
            </div>
        @endif

        {{-- CONTEÚDO DAS PÁGINAS --}}
        <div class="p-6 page-transition">
            @yield('content')
        </div>

    </main>

</div>

@yield('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnBell = document.getElementById('btn-bell');
        const dropdown = document.getElementById('notifications-dropdown');

        if (!btnBell || !dropdown) return;

        btnBell.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function (e) {
            if (!dropdown.classList.contains('hidden')) {
                if (!dropdown.contains(e.target) && !btnBell.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            }
        });
    });
</script>

</body>
</html>
