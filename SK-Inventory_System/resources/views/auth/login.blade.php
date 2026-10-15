<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Inventory System - Sign In</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom Background with Low Opacity Overlay */
        .login-bg {
            background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.85)), url('{{ asset('asset/sk.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Formal Spinner Animation */
        @keyframes spin-slow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 1.5s linear infinite;
        }
    </style>
</head>

<body class="login-bg text-slate-800 flex flex-col min-h-screen justify-between">

    <!-- FORMAL LOADING SPLASH SCREEN -->
    <div id="loading-screen" class="fixed inset-0 z-50 bg-[#1B2A4A] flex flex-col items-center justify-center transition-opacity duration-700">
        <div class="relative flex items-center justify-center">
            <!-- Rotating Gold Border Ring -->
            <div class="absolute w-24 h-24 rounded-full border-4 border-yellow-400 border-t-transparent animate-spin-slow"></div>
            <!-- Center SK Logo -->
            <img src="{{ asset('asset/sk.png') }}" alt="SK Logo" class="w-16 h-16 rounded-full object-contain bg-white p-1 shadow-lg" onerror="this.onerror=null; this.src='https://via.placeholder.com/64?text=SK';">
        </div>
        <div class="mt-6 text-center">
            <h2 class="text-white text-sm font-bold tracking-wider uppercase">Sangguniang Kabataan</h2>
            <p class="text-xs text-yellow-400 mt-1 font-medium">Initializing Property & Inventory System...</p>
        </div>
    </div>

    {{-- TOP BAR / HEADER BANNER --}}
    <header class="bg-[#1B2A4A]/90 backdrop-blur-md text-white border-b-4 border-yellow-400 py-3 px-6 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-3">
                
                <!-- LOGO IMAGE IN HEADER -->
                <img src="{{ asset('asset/sk.png') }}"
                     alt="SK Logo" 
                     class="w-10 h-10 rounded-full object-contain bg-white p-0.5 border border-yellow-400 shadow-sm"
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/40?text=SK';">
                
                <div>
                    <p class="text-[10px] tracking-wider uppercase text-slate-300">Sangguniang Kabataan Management</p>
                    <p class="text-sm font-bold tracking-tight">Property & Inventory System</p>
                </div>
            </div>

            <div class="text-xs text-slate-300 hidden sm:block text-right">
                <span class="block font-semibold">Republic of the Philippines</span>
                <span class="text-[10px] text-yellow-400 font-medium">Official Portal</span>
            </div>
        </div>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="flex-grow flex items-center justify-center px-4 py-10">
        <div class="max-w-md w-full bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-slate-200 overflow-hidden">
            
            <!-- CARD HEADER WITH LOGO -->
            <div class="bg-[#1B2A4A] text-white px-6 py-6 text-center flex flex-col items-center">
                
                <!-- MAIN CENTER LOGO -->
                <div class="mb-3 p-1 bg-white/10 rounded-full">
                    <img src="{{ asset('asset/sk.png') }}" 
                         alt="SK Official Seal" 
                         class="w-16 h-16 rounded-full object-contain bg-white p-1 border-2 border-yellow-400 shadow-md"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/64?text=SK+Logo';">
                </div>

                <h2 class="text-xl font-bold tracking-tight">SK Inventory System - Login</h2>
                <p class="text-xs text-slate-300 mt-1">Supplies & Materials Inventory Database</p>
            </div>

            <!-- SESSION STATUS MESSAGES -->
            @if (session('status'))
                <div class="mb-2 font-medium text-sm text-green-600 px-6 pt-4">
                    {{ session('status') }}
                </div>
            @endif

            <!-- LOGIN FORM -->
            <form method="POST" action="{{ route('login') }}" class="p-6 space-y-4">
                @csrf

                <!-- EMAIL FIELD -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">
                        Official Email / Username <span class="text-red-500">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] text-sm"
                           placeholder="sk.officer@barangay.gov.ph">

                    @error('email')
                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror 
                </div>

                <!-- PASSWORD FIELD -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600">
                            Password <span class="text-red-500">*</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-blue-700 hover:underline">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <input id="password" type="password" name="password" required 
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] text-sm"
                           placeholder="••••••••">

                    @error('password')
                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- REMEMBER ME CHECKBOX -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-[#1B2A4A] focus:ring-[#1B2A4A] border-slate-300 rounded">
                    <label for="remember_me" class="ml-2 block text-xs text-slate-700">
                        Keep me logged in on this device
                    </label>
                </div>

                <!-- SUBMIT BUTTON -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#1B2A4A] hover:bg-[#142038] text-white font-semibold py-2.5 px-4 rounded-lg transition duration-150 text-sm shadow-md">
                        Sign In to Inventory
                    </button>
                </div>
            </form>

            <!-- CARD FOOTER DISCLAIMER -->
            <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 text-center">
                <p class="text-[11px] text-slate-500">
                    Restricted system for authorized SK Council Members & Staff only.
                </p>
            </div>
        </div>
    </main>

    <!-- OFFICIAL FOOTER -->
    <footer class="bg-[#1B2A4A]/90 backdrop-blur-md text-slate-400 text-xs py-4 px-6 border-t border-slate-800 text-center flex flex-col sm:flex-row items-center justify-between max-w-7xl mx-auto w-full">
        <p>Sangguniang Kabataan Inventory Management System</p>
        <p class="text-[10px] text-yellow-400 mt-1 sm:mt-0 font-semibold">Aktibo. Inklusibo. Progresibo.</p>
    </footer>

    <!-- LOADING SCREEN SCRIPT -->
    <script>
        window.addEventListener('load', function () {
            const loader = document.getElementById('loading-screen');
            // Brief formal pause (0.8 seconds) then fade out smoothly
            setTimeout(function () {
                loader.style.opacity = '0';
                setTimeout(function () {
                    loader.style.display = 'none';
                }, 700);
            }, 800);
        });
    </script>

</body>
</html>