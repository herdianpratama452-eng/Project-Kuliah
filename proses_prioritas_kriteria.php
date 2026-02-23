<?php
session_start();

// Ambil matriks normalisasi dari session
$matrikNorm = $_SESSION['matrikNorm'] ?? [];

// Daftar kriteria
$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);

// Validasi
if (empty($matrikNorm)) {
    header("Location: matrik_nilai_kriteria.php");
    exit;
}

$proses = [];
$prioritas = [];

// ================================
// PROSES HITUNG BOBOT PRIORITAS
// ================================
for ($i = 0; $i < $n; $i++) {
    $row = $matrikNorm[$i];          // Ambil baris normalisasi
    $sum = array_sum($row);          // Jumlahkan baris
    $prior = $sum / $n;              // Rata-rata = bobot prioritas

    $proses[$i] = [
        'kriteria'  => $kriteria[$i],
        'row'       => $row,
        'sum'       => $sum,
        'prioritas' => $prior
    ];

    $prioritas[$i] = $prior;
}

$_SESSION['prioritas'] = $prioritas;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bobot Prioritas - Navy Dark</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        .result-card {
            background-color: #1e293b;
            border: 1px solid #334155;
        }

        .progress-bg {
            background-color: #0f172a;
        }

        .formula-box {
            background-color: rgba(15, 23, 42, 0.5);
            font-family: 'Fira Code', monospace;
        }
    </style>
</head>

<body class="py-12 px-4 bg-gradient-to-br from-[#0f172a] via-[#111827] to-[#000000] min-h-screen">

    <div class="max-w-5xl mx-auto">

        <div class="text-center mb-12">
            <h2 class="text-4xl font-black text-white tracking-tight mb-3">Bobot Prioritas Kriteria</h2>
            <p class="text-slate-400 font-medium italic">Hasil perhitungan Eigenvector untuk setiap kriteria penilaian.</p>
        </div>

        <div class="result-card rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-700/50">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/80 border-b border-slate-700">
                            <th class="px-8 py-6 text-xs font-black text-slate-500 uppercase tracking-[0.2em]">Kriteria</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-300 uppercase tracking-[0.2em]">Logika Perhitungan (Rata-Rata Baris)</th>
                            <th class="px-8 py-6 text-xs font-black text-blue-400 uppercase tracking-[0.2em] text-right">Bobot Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <?php foreach ($proses as $p): ?>
                            <tr class="hover:bg-slate-700/20 transition-all group">
                                <td class="px-8 py-8">
                                    <div class="font-black text-white text-lg tracking-tight group-hover:text-blue-400 transition-colors">
                                        <?= $p['kriteria'] ?>
                                    </div>
                                    <div class="w-full h-1.5 progress-bg rounded-full mt-3 overflow-hidden">
                                        <div class="h-full bg-blue-500 rounded-full" style="width: <?= $p['prioritas'] * 100 ?>%"></div>
                                    </div>
                                </td>

                                <td class="px-8 py-8">
                                    <div class="formula-box p-3 rounded-xl border border-slate-800 text-xs text-slate-400 leading-relaxed">
                                        <span class="text-slate-500">(</span>
                                        <?= implode(" + ", array_map(function ($x) {
                                            return '<span class="text-blue-400/80">' . number_format($x, 2) . '</span>';
                                        }, $p['row'])) ?>
                                        <span class="text-slate-500">)</span>
                                        <span class="mx-2 text-white">/</span>
                                        <span class="text-white"><?= $n ?></span>
                                    </div>
                                </td>

                                <td class="px-8 py-8 text-right">
                                    <div class="text-2xl font-black text-blue-400">
                                        <?= number_format($p['prioritas'] * 100, 1) ?><span class="text-sm ml-1">%</span>
                                    </div>
                                    <div class="text-[10px] text-slate-500 font-mono mt-1">
                                        VAL: <?= number_format($p['prioritas'], 4) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-10 bg-blue-500/5 border border-blue-500/10 p-6 rounded-3xl flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-lightbulb text-blue-400 text-sm"></i>
            </div>
            <div>
                <h4 class="text-blue-400 font-bold text-sm uppercase tracking-widest mb-1">Informasi</h4>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Bobot prioritas di atas menunjukkan tingkat pengaruh kriteria terhadap keputusan akhir.
                    Semakin besar persentasenya, semakin dominan kriteria tersebut dalam menentukan kelayakan alternatif.
                </p>
            </div>
        </div>

        <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="matrik_nilai_kriteria.php" class="px-8 py-4 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-2xl transition flex items-center group">
                <i class="fas fa-arrow-left mr-3 transition-transform group-hover:-translate-x-1"></i> Kembali
            </a>

            <a href="Perhitungan rasio konsistensi.php"
                class="px-10 py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-2xl shadow-[0_15px_30px_-10px_rgba(16,185,129,0.4)] transition-all transform hover:-translate-y-1 active:scale-95 flex items-center">
                Cek Rasio Konsistensi <i class="fas fa-check-double ml-3"></i>
            </a>
        </div>
    </div>

</body>

</html>