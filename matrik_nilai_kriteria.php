<?php
session_start();

$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);

// Ambil matriks dari session
$matrik = $_SESSION['matrikKriteria'] ?? [];

if (empty($matrik)) {
    header("Location: matrik_kriteria.php");
    exit;
}

// Hitung jumlah tiap kolom
$jumlahKolom = [];
for ($j = 0; $j < $n; $j++) {
    $jumlahKolom[$j] = 0;
    for ($i = 0; $i < $n; $i++) {
        $jumlahKolom[$j] += $matrik[$i][$j];
    }
}

// Matriks normalisasi = nilai sel / jumlah kolom
$matrikNorm = [];
for ($i = 0; $i < $n; $i++) {
    for ($j = 0; $j < $n; $j++) {
        // Menggunakan presisi 4 desimal untuk akurasi AHP yang lebih baik secara visual
        $matrikNorm[$i][$j] = round($matrik[$i][$j] / $jumlahKolom[$j], 4);
    }
}

// Simpan matriks normalisasi ke session untuk prioritas
$_SESSION['matrikNorm'] = $matrikNorm;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normalisasi Kriteria - Navy Dark</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cell-calc {
            font-size: 0.65rem;
            color: #64748b;
        }

        .norm-value {
            color: #38bdf8;
            font-weight: 700;
        }
    </style>
</head>

<body class="py-12 px-4 bg-gradient-to-br from-[#0f172a] via-[#111827] to-[#000000] min-h-screen">

    <div class="max-w-6xl mx-auto">

        <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-4">
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-black text-white tracking-tight">Matriks Normalisasi</h2>
                <p class="text-slate-400 mt-1 italic font-medium">Tahap standardisasi nilai perbandingan berpasangan.</p>
            </div>
            <div class="bg-blue-500/10 border border-blue-500/20 px-4 py-2 rounded-full flex items-center">
                <span class="animate-pulse w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                <span class="text-blue-400 text-xs font-bold uppercase tracking-widest">Processing Phase</span>
            </div>
        </div>

        <div class="glass-card rounded-[2rem] shadow-2xl overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse">
                    <thead>
                        <tr class="bg-slate-900/80 border-b border-slate-700">
                            <th class="px-6 py-5 text-xs font-black text-slate-500 uppercase tracking-widest text-left">Kriteria</th>
                            <?php foreach ($kriteria as $k): ?>
                                <th class="px-6 py-5 text-xs font-black text-slate-300 uppercase tracking-widest"><?= $k ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <?php for ($i = 0; $i < $n; $i++): ?>
                            <tr class="hover:bg-slate-700/20 transition-colors">
                                <td class="px-6 py-6 font-bold text-white text-left bg-slate-900/30 border-r border-slate-800">
                                    <?= $kriteria[$i] ?>
                                </td>
                                <?php for ($j = 0; $j < $n; $j++): ?>
                                    <td class="px-4 py-6">
                                        <div class="norm-value text-lg"><?= number_format($matrikNorm[$i][$j], 3) ?></div>
                                        <div class="cell-calc mt-1 font-mono">
                                            (<?= $matrik[$i][$j] ?> / <?= round($jumlahKolom[$j], 2) ?>)
                                        </div>
                                    </td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="text-slate-500 text-sm bg-slate-800/30 p-6 rounded-2xl border border-slate-700/50">
                <h4 class="text-slate-300 font-bold mb-2 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-400"></i> Apa itu Normalisasi?
                </h4>
                <p>Proses ini membagi setiap sel dengan total jumlah kolomnya. Hasil ini nantinya akan dirata-rata untuk mendapatkan <strong>Bobot Prioritas (Eigenvector)</strong> dari setiap kriteria.</p>
            </div>

            <div class="flex flex-col gap-4">
                <a href="proses_prioritas_kriteria.php"
                    class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl shadow-xl shadow-blue-900/40 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center">
                    Lihat Bobot Prioritas <i class="fas fa-arrow-right ml-3"></i>
                </a>
                <a href="matrik_kriteria.php" class="text-center text-slate-500 hover:text-slate-300 font-bold text-sm transition">
                    <i class="fas fa-undo mr-2"></i> Re-evaluasi Matriks Perbandingan
                </a>
            </div>
        </div>
    </div>

</body>

</html>