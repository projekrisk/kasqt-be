<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi | Kasqt</title>
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
        <div class="glass p-8 md:p-12 rounded-3xl shadow-2xl">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Kebijakan Privasi</h1>
            <p class="text-slate-400 mb-8 text-sm">Pembaruan Terakhir: 17 Agustus 2026</p>

            <div class="space-y-6 text-slate-300 leading-relaxed text-sm md:text-base">
                <p>Kami di <strong>Kasqt</strong> berkomitmen penuh untuk melindungi privasi finansial Anda. Kebijakan ini menjelaskan bagaimana data Anda dikumpulkan, digunakan, dan dilindungi.</p>
                
                <h2 class="text-xl font-bold text-white mt-8 mb-4">1. Data yang Kami Kumpulkan</h2>
                <ul class="list-disc pl-5 space-y-2">
                    <li><strong>Data Akun:</strong> Nama, alamat email, dan foto profil Anda melalui Login Google.</li>
                    <li><strong>Data Finansial:</strong> Nominal hutang-piutang, catatan transaksi, bukti pembayaran (gambar), dan tanggal jatuh tempo yang Anda masukkan.</li>
                    <li><strong>Buku Kontak:</strong> Kami memindai nomor telepon dengan enkripsi hash <em>hanya</em> untuk mencocokkan pengguna di aplikasi kami (sinkronisasi data). Kami tidak menjual atau membagikan kontak Anda kepada pihak ketiga.</li>
                </ul>

                <h2 class="text-xl font-bold text-white mt-8 mb-4">2. Bagaimana Kami Menggunakan Data Anda</h2>
                <p>Data Anda digunakan murni untuk operasional aplikasi, sinkronisasi antar perangkat, mengirimkan notifikasi jatuh tempo (FCM), serta memfasilitasi pembuatan Laporan PDF untuk akun PRO.</p>

                <h2 class="text-xl font-bold text-white mt-8 mb-4">3. Kemanan & Enkripsi</h2>
                <p>Data dikirim menggunakan standar enkripsi SSL/TLS mutakhir. Database kami diproteksi secara ketat. Bukti transfer yang Anda lampirkan disimpan di ruang yang hanya bisa diakses menggunakan tautan otentik.</p>
            </div>
        </div>
    </main>

</body>
</html>