<!DOCTYPE html>
<html lang="id" class="dark"> <!-- Class 'dark' penting agar input form Filament menjadi mode gelap -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin | Kasqt</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        kasqt: {
                            dark: '#020617',
                            card: '#0F172A',
                            emerald: '#10B981',
                            emerald_dark: '#065F46',
                            gold: '#F59E0B',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'pulse-slow': 'pulse 8s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <style>
        body, html {
            margin: 0; padding: 0; height: 100%; overflow: hidden; background-color: #020617; color: #ffffff;
        }
        .glass {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .glow-emerald {
            position: absolute; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, rgba(2,6,23,0) 70%);
            border-radius: 50%; top: -200px; right: -100px; z-index: 0;
        }
        .glow-gold {
            position: absolute; width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, rgba(2,6,23,0) 70%);
            border-radius: 50%; bottom: -200px; left: -100px; z-index: 0;
        }
    </style>

    <!-- Wajib untuk Form Filament -->
    @filamentStyles
</head>
<body class="antialiased flex flex-col relative selection:bg-kasqt-emerald selection:text-white min-h-screen">

    <div class="glow-emerald animate-pulse-slow"></div>
    <div class="glow-gold animate-pulse-slow" style="animation-delay: 2s;"></div>

    <nav class="relative z-50 w-full px-8 md:px-16 py-6 flex justify-between items-center">
        <div class="flex items-center gap-2 cursor-pointer">
            <img src="{{ asset('images/icon.png') }}" alt="Kasqt Logo" class="w-8 h-8 rounded-lg shadow-lg shadow-emerald-900/50 object-cover">
            <span class="text-2xl font-bold tracking-tight">Kasqt<span class="text-kasqt-emerald">.</span></span>
        </div>
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
            <a href="#" onclick="openInfoModal('fitur'); return false;" class="hover:text-white transition-colors duration-300">Fitur</a>
            <a href="#" onclick="openInfoModal('keamanan'); return false;" class="hover:text-white transition-colors duration-300">Keamanan</a>
            <a href="#" onclick="openInfoModal('pro'); return false;" class="flex items-center gap-1.5 hover:text-white transition-colors duration-300">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="text-kasqt-gold"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                PRO
            </a>
        </div>
    </nav>

    <!-- TEMPAT FORM LOGIN AKAN DI-RENDER -->
    {{ $slot }}

    <footer class="absolute bottom-0 w-full px-8 py-6 text-center lg:text-left z-50 pointer-events-none">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-[11px] text-slate-600 font-medium tracking-wide uppercase pointer-events-auto">
            <span>&copy; {{ date('Y') }} Kasqt. Hak Cipta Dilindungi.</span>
        </div>
    </footer>

    <!-- Wajib untuk interaktivitas Form Filament -->
    @filamentScripts
</body>
</html>