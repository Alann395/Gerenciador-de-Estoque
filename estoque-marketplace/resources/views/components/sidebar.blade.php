<button onclick="toggleSidebar()" 
class="text-gray-400 hover:text-blue-400 mb-6">
    <i class="lucide-menu w-6 h-6"></i>
</button>

<div 
    x-data="{ open: false }"
    @mouseenter="open = true"
    @mouseleave="open = false"
    class="fixed left-0 top-0 h-screen bg-[#0d1117] border-r border-blue-500/30
           backdrop-blur-xl flex flex-col items-center py-6 shadow-lg shadow-blue-neon
           transition-all duration-300 z-40"
    :class="open ? 'w-56' : 'w-16'"
>

    <!-- Logo -->
    <div class="mb-8">
        <svg class="w-8 h-8 text-blue-400 drop-shadow-neon" fill="none" stroke="currentColor" stroke-width="1.5"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 7.5l9-4.5 9 4.5-9 4.5-9-4.5z"/>
        </svg>
    </div>

    <!-- Menu -->
    <nav class="flex flex-col gap-4 w-full px-2 text-gray-300">
        
        <a href="/dashboard" class="menu-item">
            <i class="icon lucide-home"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <a href="/produtos" class="menu-item">
            <i class="icon lucide-box"></i>
            <span class="menu-text">Produtos</span>
        </a>

        <a href="/clientes" class="menu-item">
            <i class="icon lucide-users"></i>
            <span class="menu-text">Clientes</span>
        </a>

        <a href="/config" class="menu-item">
            <i class="icon lucide-settings"></i>
            <span class="menu-text">Configurações</span>
        </a>

    </nav>

</div>
