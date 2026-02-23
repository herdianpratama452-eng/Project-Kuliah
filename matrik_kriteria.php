<?php
session_start();
$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);
$matrikPrev = $_SESSION['matrikKriteria'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matrik = [];
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $key = "nilai_{$i}_{$j}";
            // Paksa nilai 1 jika diagonal, jika tidak ambil dari input
            $val = ($i == $j) ? 1 : (isset($_POST[$key]) ? floatval($_POST[$key]) : 1);
            if ($val <= 0) $val = 1;
            $matrik[$i][$j] = $val;
        }
    }
    $_SESSION['matrikKriteria'] = $matrik;
    header("Location: matrik_nilai_kriteria.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Matriks Kriteria - Navy Dark</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        .matrix-card {
            background-color: #1e293b;
            border: 1px solid #334155;
        }

        input[type=number] {
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #60a5fa;
            text-align: center;
        }

        .diagonal-cell {
            background-color: rgba(51, 65, 85, 0.5) !important;
            color: #94a3b8 !important;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="py-12 px-4 bg-gradient-to-br from-[#0f172a] to-[#000000] min-h-screen">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-black text-white mb-2">Matriks Perbandingan</h2>
            <p class="text-slate-400 italic">Berikan nilai 1-9 untuk tingkat kepentingan kriteria.</p>
        </div>
        <form method="POST">
            <div class="matrix-card rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-slate-900/50">
                                <th class="px-6 py-5 text-xs font-black text-slate-300 uppercase tracking-widest border-b border-slate-700 text-left">Kriteria</th>
                                <?php foreach ($kriteria as $k): ?>
                                    <th class="px-6 py-5 text-xs font-black text-blue-400 uppercase tracking-widest border-b border-slate-700"><?= $k ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            <?php for ($i = 0; $i < $n; $i++): ?>
                                <tr>
                                    <td class="px-6 py-4 font-bold text-slate-200 bg-slate-900/20 border-r border-slate-700"><?= $kriteria[$i] ?></td>
                                    <?php for ($j = 0; $j < $n; $j++): ?>
                                        <td class="px-4 py-4 text-center">
                                            <input type="number" step="0.01" name="nilai_<?= $i ?>_<?= $j ?>"
                                                value="<?= ($i == $j) ? 1 : ($matrikPrev[$i][$j] ?? 1) ?>"
                                                <?= ($i == $j) ? 'readonly class="diagonal-cell w-20 py-2 rounded-xl font-bold"' : 'class="w-20 py-2 rounded-xl font-medium focus:ring-2 transition"' ?>>
                                        </td>
                                    <?php endfor; ?>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-10 flex flex-col items-center gap-4">
                <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl shadow-lg transition-all transform hover:-translate-y-1">
                    <i class="fas fa-save mr-2"></i> Simpan & Lanjut
                </button>
            </div>
        </form>
    </div>
</body>

</html>