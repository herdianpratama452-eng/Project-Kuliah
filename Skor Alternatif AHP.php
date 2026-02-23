<?php
session_start();

// ==========================
// DATA ALTERNATIF & SKOR
// ==========================
$namaAlternatif = ["Alternatif A1", "Alternatif A2", "Alternatif A3", "Alternatif A4"];

// Mengambil skor dari session jika tersedia, jika tidak pakai data dummy
$skor = $_SESSION['skorAlternatif'] ?? [0.3224, 0.5562, 0.2964, 0.6618];

// ==========================
// Tentukan Ranking dan Kelayakan
// ==========================
$rankingData = [];
foreach ($skor as $index => $nilai) {
    $rankingData[] = [
        'nama' => $namaAlternatif[$index],
        'skor' => $nilai,
        'index' => $index
    ];
}

// Urutkan skor dari yang terbesar ke terkecil
usort($rankingData, function ($a, $b) {
    return $b['skor'] <=> $a['skor'];
});

// Pemenang adalah urutan pertama setelah diurutkan
$pemenang = $rankingData[0];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Akhir AHP - Navy Dark</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .winner-border {
            border: 2px solid #eab308;
            box-shadow: 0 0 20px rgba(234, 179, 8, 0.2);
        }

        @media print {
            body {
                /* Memaksa warna latar belakang muncul */
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                background-color: #0f172a !important;
            }

            /* Sembunyikan tombol navigasi saat diprint */
            .flex,
            button,
            a,
            i {
                display: none !important;
            }

            /* Pastikan kartu tetap memiliki warna */
            .glass-card {
                background-color: #1e293b !important;
                border: 1px solid #334155 !important;
                box-shadow: none !important;
            }

            /* Pastikan teks tetap berwarna putih terang */
            h1,
            h2,
            h3,
            p,
            td,
            th,
            span {
                color: #f1f5f9 !important;
            }
        }
    </style>
</head>

<body class="py-12 px-4 bg-gradient-to-br from-[#0f172a] via-[#111827] to-[#000000] min-h-screen font-sans">

    <div class="max-w-4xl mx-auto">

        <div class="text-center mb-10">
            <h2 class="text-4xl font-black text-white tracking-tight mb-2">Keputusan Akhir</h2>
            <p class="text-slate-400 font-medium">Berdasarkan perhitungan Analytical Hierarchy Process (AHP)</p>
        </div>

        <div class="glass-card rounded-[2.5rem] p-8 mb-10 border-t-4 border-t-yellow-500 text-center relative overflow-hidden">
            <div class="absolute -right-10 -top-10 text-yellow-500/10 text-9xl">
                <i class="fas fa-trophy"></i>
            </div>

            <span class="bg-yellow-500/20 text-yellow-500 px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest">Rekomendasi Terbaik</span>
            <h1 class="text-5xl font-black text-white mt-4 mb-2"><?= $pemenang['nama'] ?></h1>
            <p class="text-slate-400">Terpilih sebagai alternatif paling layak dengan skor tertinggi sebesar <span class="text-yellow-500 font-bold"><?= number_format($pemenang['skor'], 4) ?></span></p>
        </div>

        <div class="glass-card rounded-[2rem] shadow-2xl overflow-hidden mb-10">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-700">
                        <th class="px-8 py-5 text-xs font-black text-slate-500 uppercase tracking-widest w-24 text-center">Rank</th>
                        <th class="px-8 py-5 text-xs font-black text-slate-300 uppercase tracking-widest">Nama Alternatif</th>
                        <th class="px-8 py-5 text-xs font-black text-slate-300 uppercase tracking-widest">Skor Akhir</th>
                        <th class="px-8 py-5 text-xs font-black text-blue-400 uppercase tracking-widest text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php foreach ($rankingData as $rank => $data): ?>
                        <tr class="transition-all <?= ($rank == 0) ? 'bg-yellow-500/5' : 'hover:bg-slate-700/20' ?>">
                            <td class="px-8 py-6 text-center">
                                <span class="font-black <?= ($rank == 0) ? 'text-yellow-500 text-xl' : 'text-slate-500' ?>">#<?= $rank + 1 ?></span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="font-bold text-white"><?= $data['nama'] ?></div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-slate-300 font-mono"><?= number_format($data['skor'], 4) ?></div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <?php if ($rank == 0): ?>
                                    <span class="bg-emerald-500/20 text-emerald-400 px-4 py-1.5 rounded-lg text-xs font-black uppercase tracking-tight">
                                        <i class="fas fa-check-circle mr-1"></i> Layak
                                    </span>
                                <?php else: ?>
                                    <span class="bg-slate-800 text-slate-500 px-4 py-1.5 rounded-lg text-xs font-bold uppercase tracking-tight">
                                        Tidak Layak
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <button onclick="window.print()" class="px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-2xl transition flex items-center group">
                <i class="fas fa-print mr-3 opacity-50"></i> Cetak Laporan
            </button>

            <a href="index.php" class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl shadow-xl shadow-blue-900/40 transition-all transform hover:-translate-y-1 flex items-center">
                <i class="fas fa-home mr-3"></i> Kembali ke Dashboard
            </a>
        </div>

    </div>


</body>

</html>