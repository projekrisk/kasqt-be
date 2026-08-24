<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Undangan Transaksi - Kasqt</title>
    <meta name="title" content="Undangan Transaksi | Kasqt">
    <meta name="description" content="Teman Anda membagikan rincian catatan hutang/piutang. Buka aplikasi Kasqt untuk menyinkronkan transaksi ini secara otomatis.">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Undangan Transaksi | Kasqt">
    <meta property="og:description" content="Teman Anda membagikan rincian catatan hutang/piutang. Buka aplikasi Kasqt untuk menyinkronkan transaksi ini secara otomatis.">
    <meta property="og:image" content="{{ asset('images/og-kasqt.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Undangan Transaksi | Kasqt">
    <meta property="twitter:description" content="Teman Anda membagikan rincian catatan hutang/piutang. Buka aplikasi Kasqt untuk menyinkronkan transaksi ini secara otomatis.">
    <meta property="twitter:image" content="{{ asset('images/og-kasqt.png') }}">

    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #020617; }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <div class="absolute w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-3xl -top-40 -right-20 pointer-events-none"></div>
    <div class="absolute w-[400px] h-[400px] bg-blue-500/10 rounded-full blur-3xl -bottom-20 -left-20 pointer-events-none"></div>

    <div class="bg-[#0F172A]/80 backdrop-blur-xl border border-slate-800 p-8 md:p-10 rounded-3xl shadow-2xl max-w-md w-full text-center relative z-10">
        <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg shadow-emerald-900/50">
            <img src="{{ asset('images/icon.png') }}" alt="Kasqt" class="w-10 h-10 object-contain">
        </div>

        <h1 class="text-2xl font-bold text-white mb-3">Tautan Transaksi Kasqt</h1>
        <p class="text-slate-400 mb-8 text-sm leading-relaxed">
            Sepertinya teman Anda membagikan riwayat catatan hutang/piutang melalui aplikasi Kasqt. <br><br>
            Untuk melihat rinciannya dan menyinkronkan transaksi ke akun Anda, silakan buka tautan ini langsung dari dalam aplikasi Kasqt.
        </p>

        <a href="intent://sync/{{ $token }}#Intent;scheme=kasqt;package=com.kasqt;end;" class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-6 rounded-xl transition shadow-lg shadow-emerald-900/30 mb-3">
            Buka di Aplikasi
        </a>

        <a href="https://play.google.com/store/apps/details?id=com.kasqt" class="block w-full bg-slate-800 text-slate-300 font-medium py-3.5 px-6 rounded-xl hover:bg-slate-700 hover:text-white transition border border-slate-700">
            Unduh Aplikasi Kasqt
        </a>

        <div class="mt-8">
            <p class="text-xs text-slate-500">
                Belum dialihkan otomatis? Ketuk tombol di atas.
            </p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.location.href = 'intent://sync/{{ $token }}#Intent;scheme=kasqt;package=com.kasqt;end;';
            }, 800);
        };
    </script>
</body>
</html>