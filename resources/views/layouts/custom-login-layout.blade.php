<!DOCTYPE html>
<html lang="id" class="dark">
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

        .fi-btn[type="submit"], .fi-btn-color-primary {
            background-color: #ffffff !important;
            color: #0F172A !important;
            border-color: #ffffff !important;
            transition: all 0.3s ease;
        }
        .fi-btn[type="submit"]:hover, .fi-btn-color-primary:hover {
            background-color: #f1f5f9 !important;
            transform: scale(1.02);
        }
        .fi-btn[type="submit"] span {
            color: #0F172A !important;
            font-weight: bold !important;
        }
    </style>

    @filamentStyles
</head>
<body class="antialiased flex flex-col relative selection:bg-kasqt-emerald selection:text-white min-h-screen">

    <div class="glow-emerald animate-pulse-slow"></div>
    <div class="glow-gold animate-pulse-slow" style="animation-delay: 2s;"></div>

    <nav class="relative z-50 w-full px-8 md:px-16 py-6 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition-opacity">
            <img src="{{ asset('images/icon.png') }}" alt="Kasqt Logo" class="w-8 h-8 rounded-lg shadow-lg shadow-emerald-900/50 object-cover">
            <span class="text-2xl font-bold tracking-tight text-white">Kasqt<span class="text-kasqt-emerald">.</span></span>
        </a>

        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
            <a href="#" onclick="openInfoModal('fitur'); return false;" class="hover:text-white transition-colors duration-300">Fitur</a>
            <a href="#" onclick="openInfoModal('keamanan'); return false;" class="hover:text-white transition-colors duration-300">Keamanan</a>
            <a href="#" onclick="openInfoModal('pro'); return false;" class="flex items-center gap-1.5 hover:text-white transition-colors duration-300">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="text-kasqt-gold"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                PRO
            </a>
        </div>

        <button class="md:hidden text-slate-300 hover:text-white" onclick="toggleMobileMenu()">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </nav>

    {{ $slot }}

    <footer class="absolute bottom-0 w-full px-8 py-6 text-center lg:text-left z-50 pointer-events-none">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-[11px] text-slate-600 font-medium tracking-wide uppercase pointer-events-auto">
            <span>&copy; {{ date('Y') }} Kasqt. Hak Cipta Dilindungi.</span>
        </div>
    </footer>

    <div id="mobileMenu" class="fixed inset-0 z-[60] bg-kasqt-dark/95 backdrop-blur-lg flex-col items-center justify-center gap-8 hidden opacity-0 transition-opacity duration-300">
        <button class="absolute top-8 right-8 text-slate-400 hover:text-white" onclick="toggleMobileMenu()">
             <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
        <a href="#" onclick="openInfoModal('fitur'); toggleMobileMenu(); return false;" class="text-2xl font-semibold text-slate-300 hover:text-white">Fitur Unggulan</a>
        <a href="#" onclick="openInfoModal('keamanan'); toggleMobileMenu(); return false;" class="text-2xl font-semibold text-slate-300 hover:text-white">Keamanan</a>
        <a href="#" onclick="openInfoModal('pro'); toggleMobileMenu(); return false;" class="text-2xl font-bold flex items-center gap-2 text-kasqt-gold">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Kasqt PRO
        </a>
    </div>

    <div id="infoModal" class="fixed inset-0 z-[100] hidden">
        <div id="modalBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-300 cursor-pointer" onclick="closeInfoModal()"></div>
        <div class="absolute inset-0 pointer-events-none flex flex-col justify-end md:justify-center items-center p-0 md:p-4">
            <div id="modalPanel" class="w-full md:max-w-md bg-kasqt-card border border-slate-800 rounded-t-[2.5rem] md:rounded-3xl shadow-2xl pointer-events-auto transform translate-y-full md:translate-y-4 md:scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[85vh]">
                <div class="w-full flex justify-center pt-4 pb-2 md:hidden cursor-pointer" onclick="closeInfoModal()">
                    <div class="w-12 h-1.5 bg-slate-700 rounded-full"></div>
                </div>
                <div class="p-8 overflow-y-auto pt-4 md:pt-8">
                    <div class="flex justify-between items-start mb-6">
                        <h3 id="modalTitle" class="text-2xl font-bold text-white tracking-tight">Title</h3>
                        <button onclick="closeInfoModal()" class="text-slate-400 hover:text-white md:block hidden bg-slate-800 rounded-full p-1.5 transition">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div id="modalContent" class="text-slate-300 text-sm leading-relaxed space-y-4"></div>
                    <button onclick="closeInfoModal()" class="mt-8 w-full bg-slate-800 text-white font-semibold py-3.5 rounded-xl hover:bg-slate-700 transition md:hidden active:scale-95">
                        Tutup Panel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modalData = {
            fitur: {
                title: "Fitur Unggulan",
                content: `
                    <ul class="space-y-4">
                        <li class="flex gap-4">
                            <div class="mt-0.5 bg-emerald-500/20 p-1.5 rounded-lg h-max"><svg class="text-kasqt-emerald w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> 
                            <span><strong class="text-white block mb-0.5">Pencatatan Intuitif</strong> Antarmuka bersih memungkinkan Anda mencatat transaksi utang dan piutang dalam hitungan detik.</span>
                        </li>
                        <li class="flex gap-4">
                            <div class="mt-0.5 bg-emerald-500/20 p-1.5 rounded-lg h-max"><svg class="text-kasqt-emerald w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> 
                            <span><strong class="text-white block mb-0.5">Sinkronisasi Real-time</strong> Tautkan riwayat secara otomatis jika rekan Anda juga menggunakan Kasqt di HP mereka.</span>
                        </li>
                        <li class="flex gap-4">
                            <div class="mt-0.5 bg-emerald-500/20 p-1.5 rounded-lg h-max"><svg class="text-kasqt-emerald w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> 
                            <span><strong class="text-white block mb-0.5">Pengingat Otomatis</strong> Server kami mengirimkan notifikasi Push otomatis saat mendekati tanggal jatuh tempo.</span>
                        </li>
                    </ul>
                `
            },
            keamanan: {
                title: "Keamanan Sistem",
                content: `
                    <p class="mb-4">Data finansial Anda adalah privasi yang sangat kami jaga ketat.</p>
                    <ul class="space-y-4">
                        <li class="flex gap-4">
                            <div class="mt-0.5 bg-slate-800 p-1.5 rounded-lg h-max"><svg class="text-white w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg></div> 
                            <span><strong class="text-white block mb-0.5">Enkripsi Basis Data</strong> Nominal, catatan, dan riwayat transaksi disimpan menggunakan sistem enkripsi terkini.</span>
                        </li>
                        <li class="flex gap-4">
                            <div class="mt-0.5 bg-slate-800 p-1.5 rounded-lg h-max"><svg class="text-white w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg></div> 
                            <span><strong class="text-white block mb-0.5">Anti Jual-Beli Data</strong> Kasqt berjanji tidak akan pernah membagikan data identitas Anda ke pengiklan pihak ketiga.</span>
                        </li>
                    </ul>
                `
            },
            pro: {
                title: "Paket Kasqt PRO",
                content: `
                    <p class="mb-4">Dapatkan pengalaman pembukuan tingkat lanjut untuk kebutuhan Anda.</p>
                    <div class="bg-slate-800/60 rounded-2xl p-5 border border-kasqt-gold/30 mb-5 shadow-lg shadow-amber-900/10">
                        <ul class="space-y-3 text-sm text-white">
                            <li class="flex items-center gap-3"><div class="w-1.5 h-1.5 rounded-full bg-kasqt-gold"></div> 100% Bebas Iklan Selamanya</li>
                            <li class="flex items-center gap-3"><div class="w-1.5 h-1.5 rounded-full bg-kasqt-gold"></div> Unduh Laporan format PDF</li>
                            <li class="flex items-center gap-3"><div class="w-1.5 h-1.5 rounded-full bg-kasqt-gold"></div> Lampirkan Foto Bukti Transfer</li>
                            <li class="flex items-center gap-3"><div class="w-1.5 h-1.5 rounded-full bg-kasqt-gold"></div> Kunci Aplikasi via Biometrik</li>
                        </ul>
                    </div>
                    <div class="text-center">
                        <span class="text-xs text-slate-400 uppercase font-bold tracking-wider">Mulai Dari</span><br>
                        <span class="text-2xl font-black text-kasqt-gold mt-1 inline-block">Rp 15.000 <span class="text-sm text-slate-400 font-medium">/ bulan</span></span>
                    </div>
                `
            }
        };

        function openInfoModal(type) {
            const data = modalData[type];
            if(!data) return;
            document.getElementById('modalTitle').innerHTML = data.title;
            document.getElementById('modalContent').innerHTML = data.content;
            const modal = document.getElementById('infoModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            modal.classList.remove('hidden');
            void modal.offsetWidth; 
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('opacity-0', 'translate-y-full', 'md:translate-y-4', 'md:scale-95');
        }

        function closeInfoModal() {
            const modal = document.getElementById('infoModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            backdrop.classList.add('opacity-0');
            panel.classList.add('opacity-0', 'translate-y-full', 'md:translate-y-4', 'md:scale-95');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
        
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.classList.add('flex');
                void menu.offsetWidth;
                menu.classList.remove('opacity-0');
            } else {
                menu.classList.add('opacity-0');
                setTimeout(() => {
                    menu.classList.add('hidden');
                    menu.classList.remove('flex');
                }, 300);
            }
        }
    </script>

    @filamentScripts
</body>
</html>