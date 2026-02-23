<?php
session_start();

// 1. Ambil Bobot Prioritas Kriteria dari session (Hasil proses sebelumnya)
// Jika session kosong, kita gunakan fallback bobot dari contoh Anda
$bobot = $_SESSION['prioritas'] ?? [0.42, 0.26, 0.16, 0.10, 0.06];

// 2. Data Alternatif (Nilai normalisasi kriteria untuk setiap alternatif)
// Dalam aplikasi nyata, nilai CR ini biasanya diambil dari database hasil normalisasi per alternatif
$CR = [
    [0.22, 0.22, 0.57, 0.57, 0.41], // A1
    [0.13, 1.00, 1.00, 0.57, 0.41], // A2
    [0.13, 0.10, 0.57, 1.00, 0.41], // A3
    [1.00, 0.10, 0.57, 1.00, 0.41]  // A4
];

$namaAlternatif = ["Alternatif A1", "Alternatif A2", "Alternatif A3", "Alternatif A4"];

$hasil_akhir = [];

// ==========================
// HITUNG SKOR ALTERNATIF
// ==========================
for ($i = 0; $i < count($CR); $i++) {
    $total = 0;
    $bagianRumus = [];

    for ($j = 0; $j < count($bobot); $j++) {
        $nilai = $bobot[$j] * $CR[$i][$j];
        $total += $nilai;
        $bagianRumus[] = "(" . round($bobot[$j], 2) . " × " . $CR[$i][$j] . ")";
    }

    $hasil_akhir[] = [
        'nama'  => $namaAlternatif[$i],
        'rumus' => implode(" + ", $bagianRumus),
        'skor'  => $total
    ];
}

// Urutkan berdasarkan skor tertinggi untuk perangkingan
usort($hasil_akhir, function ($a, $b) {
    return $b['skor'] <=> $a['skor'];
});

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skor Akhir - Navy Dark</title>
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

        .rank-1 {
            background: linear-gradient(to right, rgba(234, 179, 8, 0.1), rgba(234, 179, 8, 0.02));
            border-left: 4px solid #eab308 !important;
        }
    </style>
</head>

<body class="py-12 px-4 bg-gradient-to-br from-[#0f172a] via-[#111827] to-[#000000] min-h-screen font-sans">

    <div class="max-w-5xl mx-auto">

        <div class="text-center mb-12">
            <h2 class="text-4xl font-black text-white tracking-tight mb-4">Hasil Skor & Perangkingan</h2>
            <p class="text-slate-400 italic">Akumulasi bobot kriteria terhadap nilai setiap alternatif.</p>
        </div>

        <div class="glass-card rounded-[2.5rem] shadow-2xl overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/80 border-b border-slate-700">
                            <th class="px-8 py-6 text-xs font-black text-slate-500 uppercase tracking-widest w-20 text-center">Rank</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-300 uppercase tracking-widest">Alternatif</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-300 uppercase tracking-widest hidden md:table-cell">Proses Kalkulasi</th>
                            <th class="px-8 py-6 text-xs font-black text-blue-400 uppercase tracking-widest text-right">Skor Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <?php foreach ($hasil_akhir as $index => $h): ?>
                            <tr class="hover:bg-slate-700/20 transition-all <?= ($index == 0) ? 'rank-1' : '' ?>">
                                <td class="px-8 py-6 text-center">
                                    <?php if ($index == 0): ?>
                                        <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center text-slate-900 font-black shadow-lg shadow-yellow-500/20 mx-auto">1</div>
                                    <?php else: ?>
                                        <span class="text-slate-500 font-bold"><?= $index + 1 ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-bold text-white"><?= $h['nama'] ?></div>
                                    <div class="md:hidden text-[10px] text-slate-500 mt-1 truncate w-40"><?= $h['rumus'] ?></div>
                                </td>
                                <td class="px-8 py-6 hidden md:table-cell">
                                    <div class="text-[11px] font-mono text-slate-500 bg-slate-900/50 p-2 rounded-lg border border-slate-800 leading-relaxed">
                                        <?= $h['rumus'] ?>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="text-xl font-black <?= ($index == 0) ? 'text-yellow-500' : 'text-blue-400' ?>">
                                        <?= number_format($h['skor'], 4) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            <div class="text-slate-500 text-sm">
                <p><i class="fas fa-info-circle mr-2 text-blue-500"></i> Skor akhir didapat dari rumus: $\sum (Bobot\_Kriteria \times Nilai\_Alternatif)$</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="Perhitungan rasio konsistensi.php" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <a href="Skor Alternatif AHP.php" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-xl shadow-lg shadow-emerald-500/20 transition-all transform hover:-translate-y-1 flex items-center justify-center">
                    Simpan & Selesai <i class="fas fa-flag-checkered ml-2"></i>
                </a>
            </div>
        </div>
    </div>

</body>

</html>