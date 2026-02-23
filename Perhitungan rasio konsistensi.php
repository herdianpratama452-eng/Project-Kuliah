<?php
session_start();

// Daftar kriteria
$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);

// Ambil matriks perbandingan & prioritas dari session
$matrik = $_SESSION['matrikKriteria'] ?? [];
$prioritas = $_SESSION['prioritas'] ?? [];

if (empty($matrik) || empty($prioritas)) {
    header("Location: matrik_kriteria.php");
    exit;
}

// ==========================
// Hitung Jumlah Kolom
// ==========================
$colSum = [];
for ($j = 0; $j < $n; $j++) {
    $colSum[$j] = 0;
    for ($i = 0; $i < $n; $i++) {
        $colSum[$j] += $matrik[$i][$j];
    }
}

// ==========================
// Hitung Aw
// ==========================
$Aw = [];
for ($i = 0; $i < $n; $i++) {
    $Aw[$i] = 0;
    for ($j = 0; $j < $n; $j++) {
        $Aw[$i] += $matrik[$i][$j] * $prioritas[$j];
    }
}

// ==========================
// Hitung λi
// ==========================
$lambda_i = [];
for ($i = 0; $i < $n; $i++) {
    $lambda_i[$i] = $Aw[$i] / $prioritas[$i];
}

// ==========================
// Hitung λmaks
// ==========================
$lambdaMax = array_sum($lambda_i) / $n;

// ==========================
// Hitung CI
// ==========================
$selisih = $lambdaMax - $n;
$penyebut = $n - 1;
$CI = $selisih / $penyebut;

// ==========================
// Hitung CR
// ==========================
$RI_table = [1 => 0, 2 => 0, 3 => 0.58, 4 => 0.90, 5 => 1.12];
$RI = $RI_table[$n];

$CR = ($RI == 0 ? 0 : $CI / $RI);
$isConsistent = ($CR < 0.1);

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rasio Konsistensi - Navy Dark</title>
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

        .status-badge {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .7;
            }
        }
    </style>
</head>

<body class="py-12 px-4 bg-gradient-to-br from-[#0f172a] via-[#111827] to-[#000000] min-h-screen font-sans">

    <div class="max-w-4xl mx-auto">

        <div class="text-center mb-10">
            <h2 class="text-4xl font-black text-white tracking-tight mb-6">Uji Konsistensi</h2>

            <div class="inline-flex items-center gap-4 px-8 py-4 rounded-3xl <?= $isConsistent ? 'bg-emerald-500/10 border border-emerald-500/20' : 'bg-red-500/10 border border-red-500/20' ?>">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl <?= $isConsistent ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40' : 'bg-red-500 text-white shadow-lg shadow-red-500/40' ?>">
                    <i class="fas <?= $isConsistent ? 'fa-check-circle' : 'fa-exclamation-triangle' ?>"></i>
                </div>
                <div class="text-left">
                    <p class="text-xs font-black uppercase tracking-widest text-slate-500">Hasil Penilaian</p>
                    <p class="text-xl font-bold <?= $isConsistent ? 'text-emerald-400' : 'text-red-400' ?>">
                        <?= $isConsistent ? 'KONSISTEN' : 'TIDAK KONSISTEN' ?> (CR: <?= round($CR, 4) ?>)
                    </p>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-[2rem] shadow-2xl overflow-hidden mb-8">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-slate-900/50 border-b border-slate-700">
                        <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest text-left">Kriteria</th>
                        <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Σ Kolom</th>
                        <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Bobot (w)</th>
                        <th class="px-6 py-5 text-xs font-black text-blue-400 uppercase tracking-widest">λᵢ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php for ($i = 0; $i < $n; $i++): ?>
                        <tr class="hover:bg-slate-700/20 transition-colors">
                            <td class="px-6 py-5 font-bold text-slate-200 text-left"><?= $kriteria[$i] ?></td>
                            <td class="px-6 py-5 text-slate-400 font-mono"><?= number_format($colSum[$i], 3) ?></td>
                            <td class="px-6 py-5 text-slate-400 font-mono"><?= number_format($prioritas[$i], 4) ?></td>
                            <td class="px-6 py-5 text-blue-400 font-black"><?= number_format($lambda_i[$i], 4) ?></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="glass-card p-6 rounded-3xl border border-slate-700/50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Principal Eigenvalue</span>
                    <span class="text-blue-400 font-bold">λ Maks</span>
                </div>
                <div class="text-3xl font-black text-white"><?= number_format($lambdaMax, 4) ?></div>
                <p class="text-[10px] text-slate-500 mt-2 italic font-mono">Formula: Average of λᵢ</p>
            </div>

            <div class="glass-card p-6 rounded-3xl border border-slate-700/50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Consistency Index</span>
                    <span class="text-orange-400 font-bold">CI</span>
                </div>
                <div class="text-3xl font-black text-white"><?= number_format($CI, 4) ?></div>
                <p class="text-[10px] text-slate-500 mt-2 italic font-mono">Formula: (λmax - n) / (n - 1)</p>
            </div>
        </div>

        <div class="bg-slate-900/50 border border-slate-700 p-8 rounded-[2rem] mb-12">
            <div class="flex flex-col md:flex-row justify-around gap-8 text-center">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Random Index (RI)</p>
                    <p class="text-2xl font-black text-slate-300"><?= $RI ?></p>
                </div>
                <div class="hidden md:block w-px bg-slate-700"></div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Consistency Ratio (CR)</p>
                    <p class="text-2xl font-black <?= $isConsistent ? 'text-emerald-400' : 'text-red-400' ?>">
                        <?= number_format($CR, 4) ?>
                    </p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-800 text-center">
                <?php if ($isConsistent): ?>
                    <p class="text-sm text-slate-400">Data valid dan objektif. Silakan lanjut ke perankingan alternatif.</p>
                <?php else: ?>
                    <p class="text-sm text-red-400 font-medium italic">Peringatan: Matriks perbandingan tidak konsisten! Mohon periksa kembali penilaian Anda.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="proses_prioritas_kriteria.php" class="text-slate-500 hover:text-white font-bold transition flex items-center group">
                <i class="fas fa-chevron-left mr-2 transition-transform group-hover:-translate-x-1"></i> Kembali
            </a>

            <?php if ($isConsistent): ?>
                <a href="Perhitungan Skor Setiap Alternatif.php"
                    class="px-10 py-5 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-2xl shadow-[0_20px_40px_-10px_rgba(16,185,129,0.3)] transition-all transform hover:-translate-y-1 active:scale-95 flex items-center">
                    Lanjut ke Perankingan <i class="fas fa-crown ml-3"></i>
                </a>
            <?php else: ?>
                <a href="matrik_kriteria.php"
                    class="px-10 py-5 bg-red-600 hover:bg-red-500 text-white font-black rounded-2xl shadow-[0_20px_40px_-10px_rgba(220,38,38,0.3)] transition-all transform hover:-translate-y-1 flex items-center">
                    <i class="fas fa-undo mr-3"></i> Perbaiki Matriks
                </a>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>