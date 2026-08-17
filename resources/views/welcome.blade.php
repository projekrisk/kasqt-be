<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqt | Catat Finansial, Jaga Relasi</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        kasqt: {
                            dark: '#020617', // Slate 950
                            card: '#0F172A', // Slate 900
                            emerald: '#10B981', // Emerald 500
                            emerald_dark: '#065F46', // Emerald 800
                            gold: '#F59E0B', // Amber 500
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'pulse-slow': 'pulse 8s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0) rotate(-2deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(0deg)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Base Reset to enforce Single Screen constraint */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden; /* Mencegah scrolling halaman */
            background-color: #020617;
            color: #ffffff;
        }

        /* Glassmorphism Utilities */
        .glass {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Ambient Glows */
        .glow-emerald {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, rgba(2,6,23,0) 70%);
            border-radius: 50%;
            top: -200px;
            right: -100px;
            z-index: 0;
        }

        .glow-gold {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, rgba(2,6,23,0) 70%);
            border-radius: 50%;
            bottom: -200px;
            left: -100px;
            z-index: 0;
        }
        
        /* Custom scrollbar for modal */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="antialiased flex flex-col relative selection:bg-kasqt-emerald selection:text-white">

    <div class="glow-emerald animate-pulse-slow"></div>
    <div class="glow-gold animate-pulse-slow" style="animation-delay: 2s;"></div>

    <nav class="relative z-50 w-full px-8 md:px-16 py-6 flex justify-between items-center">
        <div class="flex items-center gap-2 cursor-pointer">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-kasqt-emerald to-emerald-700 flex items-center justify-center shadow-lg shadow-emerald-900/50">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 7.28V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2.28A2 2 0 0 0 20 15V9a2 2 0 0 0 1-1.72z"/><path d="M20 9v6h-7V9h7z"/><circle cx="16" cy="12" r="1"/></svg>
            </div>
            <span class="text-2xl font-bold tracking-tight">Kasqt<span class="text-kasqt-emerald">.</span></span>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
            <a href="#" onclick="openInfoModal('fitur'); return false;" class="hover:text-white transition-colors duration-300">Fitur</a>
            <a href="#" onclick="openInfoModal('keamanan'); return false;" class="hover:text-white transition-colors duration-300">Keamanan</a>
            <a href="#" onclick="openInfoModal('pro'); return false;" class="flex items-center gap-1.5 hover:text-white transition-colors duration-300">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="text-kasqt-gold"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                PRO
            </a>
        </div>

        <!-- Hamburger Menu Button untuk Mobile -->
        <button class="md:hidden text-slate-300 hover:text-white" onclick="toggleMobileMenu()">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </nav>

    <main class="relative z-10 flex-1 flex flex-col lg:flex-row items-center px-8 md:px-16 lg:px-24 w-full max-w-7xl mx-auto h-full pb-10 lg:pb-0">
        
        <!-- Left Column: Typography & CTAs -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center gap-6 mt-10 lg:mt-0 relative z-20">
            
            <h1 class="text-5xl lg:text-6xl font-bold leading-[1.1] tracking-tight">
                Catat Finansial, <br>
                <span class="font-serif italic text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">Jaga Relasi.</span>
            </h1>
            
            <p class="text-lg text-slate-400 leading-relaxed max-w-md">
                Ekosistem pencatatan hutang-piutang elegan untuk Anda. Transparan, aman dengan enkripsi, dan tersinkronisasi secara <span class="text-slate-200 font-medium">real-time</span>.
            </p>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mt-4">
                <!-- Google Play Button Mockup -->
                <button class="flex items-center gap-3 bg-white text-kasqt-dark px-6 py-3.5 rounded-xl font-semibold hover:scale-105 transition-transform duration-300 shadow-[0_0_20px_rgba(255,255,255,0.1)]">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M3 20.5v-17c0-.83.67-1.5 1.5-1.5.31 0 .61.1.86.28l14.18 9.93c.68.48.84 1.41.36 2.09-.16.23-.37.42-.61.56L5.3 21.68c-.73.41-1.64.15-2.05-.58-.16-.28-.25-.6-.25-.93zM5 4.5v15l10.74-7.5L5 4.5z"/></svg>
                    <div class="flex flex-col text-left">
                        <span class="text-[10px] leading-tight text-slate-600 uppercase font-bold tracking-wider">Unduh via</span>
                        <span class="text-sm leading-tight">Google Play</span>
                    </div>
                </button>

                <!-- PRO Details Button -->
                <button onclick="openInfoModal('pro')" class="flex items-center gap-2 px-6 py-3.5 rounded-xl font-semibold text-slate-300 hover:text-white border border-slate-700 hover:border-kasqt-gold/50 bg-slate-800/50 hover:bg-slate-800 transition-all duration-300 group">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-kasqt-gold group-hover:fill-kasqt-gold/20 transition-all"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    Jelajahi PRO
                </button>
            </div>
            
            <!-- Social Proof -->
            <div class="flex items-center gap-4 mt-8">
                <div class="flex -space-x-3">
                    <img src="https://ui-avatars.com/api/?name=A+B&background=0f172a&color=fff&rounded=true" alt="User" class="w-8 h-8 rounded-full border-2 border-kasqt-dark">
                    <img src="https://ui-avatars.com/api/?name=R+P&background=10b981&color=fff&rounded=true" alt="User" class="w-8 h-8 rounded-full border-2 border-kasqt-dark">
                    <img src="https://ui-avatars.com/api/?name=S+T&background=f59e0b&color=fff&rounded=true" alt="User" class="w-8 h-8 rounded-full border-2 border-kasqt-dark">
                </div>
                <div class="text-xs text-slate-500 font-medium">
                    Dipercaya ribuan pengguna <br>untuk kelola sirkulasi dana.
                </div>
            </div>
        </div>

        <div class="hidden lg:flex w-1/2 h-full justify-center items-center relative perspective-[1000px]">
            <!-- Decorative Elements -->
            <div class="absolute w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl mix-blend-screen animate-float"></div>
            
            <!-- Abstract App Mockup -->
            <div class="w-[320px] h-[650px] bg-[#090E17] border-[6px] border-slate-800 rounded-[3rem] shadow-[0_30px_60px_-15px_rgba(16,185,129,0.3)] relative overflow-hidden animate-float z-10 flex flex-col">
                
                <!-- Notch -->
                <div class="absolute top-0 inset-x-0 h-6 bg-slate-800 rounded-b-3xl w-32 mx-auto z-50"></div>
                
                <!-- Mockup Content: Dashboard -->
                <div class="flex-1 p-6 pt-12 flex flex-col gap-6 relative">
                    
                    <!-- Header -->
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="w-16 h-3 bg-slate-800 rounded-full mb-2"></div>
                            <div class="w-24 h-4 bg-slate-700 rounded-full"></div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700"></div>
                    </div>

                    <!-- Balance Card -->
                    <div class="w-full h-36 bg-gradient-to-br from-kasqt-emerald_dark to-emerald-900 rounded-2xl p-5 flex flex-col justify-between relative overflow-hidden shadow-lg shadow-emerald-900/50">
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/5 rounded-full"></div>
                        <div class="w-24 h-3 bg-white/40 rounded-full"></div>
                        <div>
                            <div class="text-white text-3xl font-bold font-sans tracking-tight mb-1">Rp 4.250<span class="opacity-50">.000</span></div>
                            <div class="flex items-center gap-2">
                                <div class="w-16 h-2 bg-emerald-400 rounded-full"></div>
                                <div class="w-8 h-2 bg-emerald-700 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity List -->
                    <div class="flex flex-col gap-4">
                        <div class="w-32 h-3 bg-slate-800 rounded-full mb-1"></div>
                        
                        <!-- Item 1 (Piutang) -->
                        <div class="w-full h-16 glass rounded-xl flex items-center px-4 gap-4 border border-slate-800">
                            <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                            </div>
                            <div class="flex-1">
                                <div class="w-20 h-3 bg-slate-300 rounded-full mb-2"></div>
                                <div class="w-12 h-2 bg-slate-600 rounded-full"></div>
                            </div>
                            <div class="w-16 h-3 bg-emerald-400 rounded-full"></div>
                        </div>

                        <!-- Item 2 (Hutang) -->
                        <div class="w-full h-16 glass rounded-xl flex items-center px-4 gap-4 border border-slate-800">
                            <div class="w-10 h-10 rounded-full bg-red-500/10 flex items-center justify-center">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                            </div>
                            <div class="flex-1">
                                <div class="w-24 h-3 bg-slate-300 rounded-full mb-2"></div>
                                <div class="w-16 h-2 bg-slate-600 rounded-full"></div>
                            </div>
                            <div class="w-14 h-3 bg-slate-500 rounded-full"></div>
                        </div>
                        
                        <!-- Item 3 (Lunas) -->
                        <div class="w-full h-16 glass rounded-xl flex items-center px-4 gap-4 border border-slate-800 opacity-50">
                            <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div class="flex-1">
                                <div class="w-16 h-3 bg-slate-500 rounded-full mb-2"></div>
                                <div class="w-12 h-2 bg-slate-700 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating FAB Mockup -->
                <div class="absolute bottom-6 right-6 w-14 h-14 bg-kasqt-emerald rounded-full shadow-lg shadow-emerald-900 flex items-center justify-center">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                </div>
            </div>

            <!-- Accent Card overlapping -->
            <div class="absolute -right-12 bottom-32 w-48 p-4 glass rounded-2xl border border-white/10 shadow-2xl animate-float-delayed z-20 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-kasqt-gold/20 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">Tersinkronisasi</div>
                    <div class="text-sm font-bold text-white">Otomatis</div>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="absolute bottom-0 w-full px-8 py-6 text-center lg:text-left z-50 pointer-events-none">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-[11px] text-slate-600 font-medium tracking-wide uppercase pointer-events-auto">
            <span>&copy; {{ date('Y') }} Kasqt. Hak Cipta Dilindungi.</span>
            <div class="flex gap-4 mt-2 md:mt-0">
                <a href="#" class="hover:text-slate-400 transition-colors">Privasi</a>
                <a href="#" class="hover:text-slate-400 transition-colors">Ketentuan</a>
                <a href="#" class="hover:text-slate-400 transition-colors">Bantuan</a>
            </div>
        </div>
    </footer>

    <!-- Hamburger Modal Mobile -->
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

    <!-- Info Modal / Bottom Sheet -->
    <div id="infoModal" class="fixed inset-0 z-[100] hidden">
        <!-- Backdrop yang bisa diklik untuk menutup -->
        <div id="modalBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-300 cursor-pointer" onclick="closeInfoModal()"></div>
        
        <!-- Pembungkus Modal agar posisinya pas -->
        <div class="absolute inset-0 pointer-events-none flex flex-col justify-end md:justify-center items-center p-0 md:p-4">
            
            <!-- Panel Putih / Gelap Modal -->
            <div id="modalPanel" class="w-full md:max-w-md bg-kasqt-card border border-slate-800 rounded-t-[2.5rem] md:rounded-3xl shadow-2xl pointer-events-auto transform translate-y-full md:translate-y-4 md:scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[85vh]">
                
                <!-- Garis Drag Mobile -->
                <div class="w-full flex justify-center pt-4 pb-2 md:hidden cursor-pointer" onclick="closeInfoModal()">
                    <div class="w-12 h-1.5 bg-slate-700 rounded-full"></div>
                </div>

                <div class="p-8 overflow-y-auto pt-4 md:pt-8">
                    <div class="flex justify-between items-start mb-6">
                        <h3 id="modalTitle" class="text-2xl font-bold text-white tracking-tight">Title</h3>
                        <!-- Tombol Tutup Silang (Hanya tampil di Desktop) -->
                        <button onclick="closeInfoModal()" class="text-slate-400 hover:text-white md:block hidden bg-slate-800 rounded-full p-1.5 transition">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div id="modalContent" class="text-slate-300 text-sm leading-relaxed space-y-4">
                        <!-- Konten disuntik via JS -->
                    </div>
                    <!-- Tombol Tutup Besar (Hanya tampil di Mobile) -->
                    <button onclick="closeInfoModal()" class="mt-8 w-full bg-slate-800 text-white font-semibold py-3.5 rounded-xl hover:bg-slate-700 transition md:hidden active:scale-95">
                        Tutup Panel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Database Konten Modal
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

        // Modal Controller
        function openInfoModal(type) {
            const data = modalData[type];
            if(!data) return;

            // Suntik teks
            document.getElementById('modalTitle').innerHTML = data.title;
            document.getElementById('modalContent').innerHTML = data.content;

            // Ambil elemen
            const modal = document.getElementById('infoModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            
            // Tampilkan wrapper utama
            modal.classList.remove('hidden');
            
            // Paksa browser membaca DOM agar transisi berjalan mulus
            void modal.offsetWidth; 
            
            // Jalankan animasi masuk
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('opacity-0', 'translate-y-full', 'md:translate-y-4', 'md:scale-95');
        }

        function closeInfoModal() {
            const modal = document.getElementById('infoModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            
            // Jalankan animasi keluar (melorot/menghilang)
            backdrop.classList.add('opacity-0');
            panel.classList.add('opacity-0', 'translate-y-full', 'md:translate-y-4', 'md:scale-95');
            
            // Sembunyikan wrapper setelah animasi (300ms) selesai
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
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

</body>
</html>