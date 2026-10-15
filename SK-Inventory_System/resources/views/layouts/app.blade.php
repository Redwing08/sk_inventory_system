<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Property & Inventory Management System</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 flex h-screen overflow-hidden">

    <!-- SIDEBAR NAVIGATION -->
    <aside class="w-64 bg-[#1B2A4A] text-slate-300 flex flex-col justify-between hidden md:flex border-r border-slate-800 shadow-lg">
        <div>
            <!-- Sidebar Header / Logo -->
            <div class="p-4 flex items-center space-x-3 border-b border-blue-900">
                <img src="{{ asset('asset/sk.png') }}" alt="SK Logo" class="w-9 h-9 rounded-full bg-white p-0.5 object-contain border border-yellow-400" onerror="this.onerror=null; this.src='https://via.placeholder.com/36?text=SK';">
                <div>
                    <h1 class="text-xs font-bold text-white tracking-wide">Inventory Management</h1>
                    <p class="text-[10px] text-slate-400">Supplies and Materials</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1 text-sm font-medium">
                
                <!-- Dashboard Link -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition text-xs font-semibold {{ request()->routeIs('dashboard') ? 'bg-blue-900 text-white shadow-sm' : 'hover:bg-blue-900/50 hover:text-white' }}">
                    <span class="w-2 h-2 rounded-full {{ request()->routeIs('dashboard') ? 'bg-yellow-400' : 'bg-transparent' }}"></span>
                    <span>Dashboard</span>
                </a>

                <div class="pt-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3">Supplies & Materials</div>
                
                <a href="{{ route('inventory.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg transition text-xs pl-6 {{ request()->routeIs('inventory.index') ? 'bg-blue-900 text-white font-semibold shadow-2xs' : 'hover:bg-blue-900/50 hover:text-white' }}">
                    Inventory List
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-900/50 hover:text-white transition text-xs pl-6">Add New Item</a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-900/50 hover:text-white transition text-xs pl-6">Stock Adjustment</a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-900/50 hover:text-white transition text-xs pl-6">Transactions</a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-900/50 hover:text-white transition text-xs pl-6">Reports</a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-900/50 hover:text-white transition text-xs mt-2">Suppliers</a>
                
                <!-- Users & Roles Link -->
                <a href="{{ route('useraccount') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition text-xs font-semibold {{ request()->routeIs('useraccount') ? 'bg-blue-900 text-white shadow-sm' : 'hover:bg-blue-900/50 hover:text-white' }}">
                    <span class="w-2 h-2 rounded-full {{ request()->routeIs('useraccount') ? 'bg-yellow-400' : 'bg-transparent' }}"></span>
                    <span>Users & Roles</span>
                </a>

                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-900/50 hover:text-white transition text-xs">Settings</a>
            </nav>
        </div>

        <!-- Sidebar Footer Branding -->
        <div class="p-4 border-t border-blue-900">
            <p class="text-xs font-black tracking-wide text-red-500 leading-tight">Aktibo.</p>
            <p class="text-xs font-black tracking-wide text-yellow-400 leading-tight">Inklusibo.</p>
            <p class="text-xs font-black tracking-wide text-blue-400 leading-tight">Progresibo.</p>
            <p class="text-[10px] text-slate-400 mt-1">#SKPinagbuhatan</p>
        </div>
    </aside>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- TOP NAVIGATION BAR -->
        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 shadow-sm">
            <div class="flex items-center space-x-4">
                <span class="font-bold text-slate-800 text-base">Inventory Management System</span>
                <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md font-medium border border-slate-200">Supplies and Materials</span>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <!-- User Profile Dropdown / Info -->
                    <div class="flex items-center space-x-3 border-l pl-4 border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-blue-900 text-white flex items-center justify-center font-bold text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-500">SK Council User</p>
                        </div>
                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline ml-2">
                            @csrf
                            <button type="submit" class="text-xs bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-md font-semibold transition border border-red-200">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-xs bg-blue-900 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-800 transition">
                        Sign In
                    </a>
                @endauth
            </div>
        </header>

        <!-- DYNAMIC CONTENT AREA -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-100">
            @yield('content')
        </main>
    </div>

    <!-- PAGE TRANSITION LOADING OVERLAY -->
    <div id="pageLoader" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-200">
        <div class="bg-white px-6 py-4 rounded-xl shadow-2xl border border-slate-200 flex items-center space-x-3">
            <div class="w-6 h-6 border-3 border-[#1B2A4A] border-t-yellow-400 rounded-full animate-spin"></div>
            <div>
                <p class="text-xs font-bold text-slate-800 tracking-wide">Loading Portal...</p>
                <p class="text-[10px] text-slate-500">Please wait while redirecting</p>
            </div>
        </div>
    </div>

    <!-- LOADING ANIMATION SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('pageLoader');
            const links = document.querySelectorAll('aside nav a');

            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    // Trigger loader only if it's a valid internal page link
                    if (href && href !== '#' && !href.startsWith('javascript')) {
                        loader.classList.remove('opacity-0', 'pointer-events-none');
                        loader.classList.add('opacity-100');
                    }
                });
            });
        });
    </script>
</body>
</html>