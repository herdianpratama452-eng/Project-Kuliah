<?php
session_start();

// Data Kriteria
$dataKriteria = $_SESSION['dataKriteria'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kriteria - Navy Dark</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f172a;
            /* Slate 900 */
            color: #f1f5f9;
        }

        /* Custom scrollbar untuk tampilan dark */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        .table-container {
            background-color: #1e293b;
            /* Slate 800 */
            border: 1px solid #334155;
        }

        .row-hover:hover {
            background-color: rgba(51, 65, 85, 0.4);
        }

        .glass-header {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(8px);
        }
    </style>
</head>

<body class="py-12 px-4 bg-gradient-to-br from-[#0f172a] via-[#111827] to-[#000000] min-h-screen">

    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-10">
            <div>
                <h2 class="text-4xl font-black text-white tracking-tight">Daftar Kriteria</h2>
                <p class="text-slate-400 mt-2 font-medium italic">Tinjau struktur hirarki penilaian Anda.</p>
            </div>
            <a href="index.php" class="mt-6 md:mt-0 inline-flex items-center text-blue-400 hover:text-blue-300 font-bold transition group">
                <i class="fas fa-edit mr-2 transition-transform group-hover:-rotate-12"></i>
                Edit Konfigurasi
            </a>
        </div>

        <div class="table-container rounded-3xl shadow-2xl overflow-hidden">
            <div class="glass-header px-8 py-5 border-b border-slate-700">
                <h3 class="font-bold text-slate-200 flex items-center tracking-wide uppercase text-sm">
                    <i class="fas fa-sitemap mr-3 text-blue-500"></i>
                    Struktur Hirarki Kriteria & Sub
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-400 border-b border-slate-700">
                            <th class="px-8 py-5 font-black uppercase text-xs tracking-[0.2em] border-r border-slate-700 w-1/3">Kriteria Utama</th>
                            <th class="px-8 py-5 font-black uppercase text-xs tracking-[0.2em]">Sub Kriteria Penilaian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        <?php if (empty($dataKriteria)): ?>
                            <tr>
                                <td colspan="2" class="px-8 py-16 text-center text-slate-500 italic">
                                    <div class="bg-slate-900/50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-800">
                                        <i class="fas fa-database text-3xl opacity-20"></i>
                                    </div>
                                    Belum ada data kriteria yang tersimpan.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($dataKriteria as $item): ?>
                                <?php $subCount = count($item['sub_kriteria']); ?>
                                <?php foreach ($item['sub_kriteria'] as $index => $sub): ?>
                                    <tr class="row-hover transition-colors">
                                        <?php if ($index === 0): ?>
                                            <td rowspan="<?= $subCount ?>" class="px-8 py-6 font-bold text-white border-r border-slate-700 align-top bg-blue-500/5">
                                                <div class="flex items-start">
                                                    <div class="mt-1.5 w-2 h-2 bg-blue-500 rounded-full shadow-[0_0_8px_rgba(59,130,246,0.6)] mr-4"></div>
                                                    <span class="tracking-wide"><?= htmlspecialchars($item['kriteria']) ?></span>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                        <td class="px-8 py-4 text-slate-300 font-light tracking-wide italic">
                                            <i class="fas fa-angle-right mr-2 text-slate-600 text-xs"></i>
                                            <?= htmlspecialchars($sub) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="alternatif.php"
                class="inline-flex items-center px-10 py-4 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-500 shadow-[0_10px_20px_-5px_rgba(37,99,235,0.4)] transition-all transform hover:-translate-y-1 active:scale-95">
                Lanjut ke Data Alternatif
                <i class="fas fa-arrow-right ml-4"></i>
            </a>

            <div class="flex items-center justify-center mt-6 space-x-2 text-slate-500">
                <i class="fas fa-info-circle text-xs"></i>
                <p class="text-xs font-medium uppercase tracking-widest">Langkah 2 dari 4: Verifikasi Data</p>
            </div>
        </div>
    </div>

</body>

</html>