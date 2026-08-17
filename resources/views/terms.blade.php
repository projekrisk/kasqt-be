<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat & Ketentuan | Kasqt</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }, colors: { kasqt: { emerald: '#10B981', dark: '#020617' } } } }
        }
    </script>
    <style>
        body { background-color: #020617; color: #ffffff; }
        .glass { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .glow-emerald { position: fixed; width: 600px; height: 600px; background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, rgba(2,6,23,0) 70%); border-radius: 50%; top: -200px; right: -100px; z-index: -1; }
    </style>
</head>
<body class="antialiased flex flex-col min-h-screen relative selection:bg-kasqt-emerald selection:text-white">
    
    <div class="glow-emerald"></div>

    <nav class="w-full px-8 md:px-16 py-6 flex justify-between items-center absolute top-0 z-50">
        <a href="{{ url('/') }}" class="flex items-center gap-2 cursor-pointer">
            <img src="{{ asset('images/icon.png') }}" alt="Kasqt" class="w-8 h-8 rounded-lg shadow-lg shadow-emerald-900/50 object-cover">
            <span class="text-2xl font-bold tracking-tight text-white">Kasqt<span class="text-kasqt-emerald">.</span></span>
        </a>
        <a href="{{ url('/') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors duration-300">Kembali ke Beranda</a>
    </nav>

    <main class="flex-1 w-full max-w-4xl mx-auto px-8 py-32 z-10">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Syarat & Ketentuan</h1>
            <p class="text-slate-400 mb-8 text-sm">Efektif mulai: 17 Agustus 2026</p>

            <div class="space-y-6 text-slate-300 leading-relaxed text-sm md:text-base">
                <p>Dengan mengunduh dan menggunakan aplikasi Kasqt, Anda setuju untuk terikat oleh Syarat dan Ketentuan berikut.</p>
                
                <h2 class="text-xl font-bold text-white mt-8 mb-4">1. Status Layanan</h2>
                <p>Kasqt adalah <strong>sebatas alat bantu pencatatan buku besar digital</strong>. Kasqt <strong>bukan</strong> entitas lembaga keuangan, platform pinjaman online (Pinjol), atau layanan penagihan utang. Kami tidak memfasilitasi transaksi uang riil; kami hanya menyimpan riwayat logikanya.</p>

                <h2 class="text-xl font-bold text-white mt-8 mb-4">2. Tanggung Jawab Pengguna</h2>
                <p>Anda bertanggung jawab penuh atas keakuratan data yang Anda masukkan ke dalam aplikasi. Segala bentuk sengketa antara Anda dan pihak kedua (yang bersangkutan dalam transaksi) adalah di luar tanggung jawab pihak Kasqt.</p>

                <h2 class="text-xl font-bold text-white mt-8 mb-4">3. Berlangganan Kasqt PRO</h2>
                <p>Pembelian status PRO bersifat langganan auto-renew (berulang) via Google Play Billing. Anda dapat membatalkan perpanjangan otomatis ini kapan saja langsung melalui menu "Langganan" pada aplikasi Google Play Store Anda. Kami tidak menyediakan opsi pengembalian dana (Refund) sepihak.</p>
            </div>
        </div>
    </main>

    <footer class="absolute bottom-0 w-full px-8 py-6 text-center lg:text-left z-50 pointer-events-none">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-[11px] text-slate-600 font-medium tracking-wide uppercase pointer-events-auto">
            <span>&copy; {{ date('Y') }} Kasqt. Hak Cipta Dilindungi.</span>
            <div class="flex gap-4 mt-2 md:mt-0">
                <a href="{{ url('/privasi') }}" class="hover:text-slate-400 transition-colors">Privasi</a>
                <a href="{{ url('/ketentuan') }}" class="hover:text-slate-400 transition-colors">Ketentuan</a>
                <a href="{{ url('/bantuan') }}" class="hover:text-slate-400 transition-colors">Bantuan</a>
            </div>
        </div>
    </footer>

</body>
</html>