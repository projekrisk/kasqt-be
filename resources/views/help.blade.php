<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan | Kasqt</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }, colors: { kasqt: { emerald: '#10B981', dark: '#020617', gold: '#F59E0B' } } } }
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

    <main class="flex-1 w-full max-w-3xl mx-auto px-8 py-32 z-10">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">Ada yang bisa dibantu?</h1>
            <p class="text-slate-400">Temukan solusi cepat dari kendala Anda di Kasqt.</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ 1 -->
            <div class="glass p-6 rounded-2xl">
                <h3 class="text-lg font-bold text-white mb-2">Bagaimana cara menautkan transaksi ke teman?</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Setelah mencatat transaksi, buka detailnya lalu klik tombol "Bagikan Tautan". Teman Anda cukup mengklik tautan tersebut (via WhatsApp) agar riwayatnya secara otomatis sinkron dengan akun mereka.
                </p>
            </div>

            <!-- FAQ 2 -->
            <div class="glass p-6 rounded-2xl">
                <h3 class="text-lg font-bold text-white mb-2">Apakah aplikasi ini berbayar?</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Aplikasi ini 100% GRATIS untuk fitur utama. Jika Anda ingin mematikan iklan, mengunci dengan sidik jari, atau mencetak Laporan PDF, Anda dapat meningkatkan (*upgrade*) ke versi Kasqt PRO.
                </p>
            </div>

            <!-- FAQ 3 -->
            <div class="glass p-6 rounded-2xl border border-kasqt-gold/20">
                <h3 class="text-lg font-bold text-kasqt-gold mb-2">Masalah dengan Langganan Kasqt PRO?</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Jika langganan tidak terdeteksi, silakan pastikan internet Anda stabil, atau masuk ke Profil > Keluar (Logout) lalu masuk kembali. Apabila kendala terus berlanjut, hubungi kami di <a href="mailto:support@kasqt.com" class="text-kasqt-emerald underline">support@kasqt.com</a>.
                </p>
            </div>
        </div>
    </main>

</body>
</html>