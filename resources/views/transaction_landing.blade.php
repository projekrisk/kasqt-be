<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Kasqt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6 text-center">

    <div class="max-w-sm w-full bg-white rounded-3xl shadow-xl p-8 border border-slate-100">
        <!-- Ikon -->
        <div class="w-16 h-16 bg-slate-900 rounded-2xl mx-auto flex items-center justify-center mb-6 shadow-lg shadow-slate-900/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </div>

        <h1 class="text-2xl font-black text-slate-900 mb-2">Kasqt.</h1>
        <p class="text-slate-500 mb-8 text-sm leading-relaxed">
            Teman Anda membagikan riwayat transaksi keuangan pada aplikasi Kasqt. <br><br>
            Untuk melihat dan menambahkan transaksi ke akun Anda.
        </p>

        <!-- FITUR BARU: Menggunakan standar Chrome Intent URI agar tidak diblokir -->
        <a href="intent://sync/{{ $token }}#Intent;scheme=kasqt;package=com.kasqt;end;" class="block w-full bg-slate-900 text-white font-medium py-4 px-6 rounded-2xl hover:bg-slate-800 transition shadow-md mb-3">
            Buka di Aplikasi
        </a>

        <!-- Tombol (Simulasi Play Store) -->
        <a href="https://play.google.com/store/apps/details?id=com.kasqt" class="block w-full bg-slate-100 text-slate-700 font-medium py-3 px-6 rounded-2xl hover:bg-slate-200 transition">
            Unduh Aplikasi Kasqt
        </a>

        <div class="mt-6">
            <p class="text-xs text-slate-400">
                Sudah punya aplikasi? Coba ketuk ulang tautan dari WhatsApp Anda.
            </p>
        </div>
    </div>

    <!-- Trik Auto-Redirect ke Aplikasi -->
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.location.href = 'intent://sync/{{ $token }}#Intent;scheme=kasqt;package=com.kasqt;end;';
            }, 300);
        };
    </script>

</body>
</html>