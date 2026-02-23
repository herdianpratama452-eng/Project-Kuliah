<?php
session_start();

// Ambil data alternatif dari session
$dataAlternatif = $_SESSION['dataAlternatif'] ?? [];

// ===== HAPUS DATA =====
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if (isset($dataAlternatif[$id])) {
        unset($dataAlternatif[$id]);
        $_SESSION['dataAlternatif'] = array_values($dataAlternatif); // reindex
        header("Location: alternatif.php");
        exit;
    }
}

// ===== EDIT DATA =====
$editData = null;
$editIndex = null;
if (isset($_GET['edit'])) {
    $editIndex = (int)$_GET['edit'];
    if (isset($dataAlternatif[$editIndex])) {
        $editData = $dataAlternatif[$editIndex];
    }
}

// ===== PROSES SIMPAN DATA (BARU / EDIT) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alternatif = trim($_POST['alternatif']);
    $jaminan = trim($_POST['jaminan']);
    $lama_pinjam = trim($_POST['lama_pinjam']);
    $kegunaan = trim($_POST['kegunaan']);
    $pengeluaran = trim($_POST['pengeluaran']);
    $pendapatan = trim($_POST['pendapatan']);

    $newData = [
        'alternatif' => $alternatif,
        'jaminan' => $jaminan,
        'lama_pinjam' => $lama_pinjam,
        'kegunaan' => $kegunaan,
        'pengeluaran' => $pengeluaran,
        'pendapatan' => $pendapatan
    ];

    if (isset($_POST['edit_index'])) {
        $index = (int)$_POST['edit_index'];
        if (isset($dataAlternatif[$index])) {
            $dataAlternatif[$index] = $newData;
        }
    } else {
        $dataAlternatif[] = $newData;
    }

    $_SESSION['dataAlternatif'] = $dataAlternatif;
    header("Location: alternatif.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Alternatif - Navy Dark</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        .form-card {
            background-color: #1e293b;
            border: 1px solid #334155;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }

        input {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }

        input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
        }

        .table-alt {
            background-color: #1e293b;
            border: 1px solid #334155;
        }

        .row-hover:hover {
            background-color: rgba(51, 65, 85, 0.4);
        }
    </style>
</head>

<body class="py-12 px-4 bg-gradient-to-br from-[#0f172a] via-[#111827] to-[#000000] min-h-screen">

    <div class="max-w-6xl mx-auto">

        <div class="text-center mb-12">
            <h2 class="text-4xl font-black text-white tracking-tight mb-3">Data Alternatif</h2>
            <p class="text-slate-400 font-medium italic">Kelola entitas pemohon dalam sistem penilaian.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1">
                <div class="form-card p-8 rounded-3xl sticky top-10">
                    <h3 class="text-lg font-bold text-white mb-6 flex items-center tracking-wide">
                        <div class="p-2 rounded-lg mr-3 <?= $editData ? 'bg-orange-500/10 text-orange-400' : 'bg-blue-500/10 text-blue-400' ?>">
                            <i class="fas <?= $editData ? 'fa-edit' : 'fa-plus-circle' ?>"></i>
                        </div>
                        <?= $editData ? "Edit Alternatif" : "Tambah Alternatif" ?>
                    </h3>

                    <form method="POST" action="" class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-widest">Nama Alternatif</label>
                            <input type="text" name="alternatif" placeholder="Budi Santoso" value="<?= $editData['alternatif'] ?? '' ?>" required
                                class="w-full px-4 py-3 rounded-xl border outline-none transition placeholder-slate-700">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-widest">Jaminan</label>
                                <input type="text" name="jaminan" placeholder="Sertifikat" value="<?= $editData['jaminan'] ?? '' ?>" required
                                    class="w-full px-4 py-3 rounded-xl border outline-none transition placeholder-slate-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-widest">Tenor</label>
                                <input type="text" name="lama_pinjam" placeholder="12 Bln" value="<?= $editData['lama_pinjam'] ?? '' ?>" required
                                    class="w-full px-4 py-3 rounded-xl border outline-none transition placeholder-slate-700">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-widest">Kegunaan</label>
                            <input type="text" name="kegunaan" placeholder="Modal Usaha" value="<?= $editData['kegunaan'] ?? '' ?>" required
                                class="w-full px-4 py-3 rounded-xl border outline-none transition placeholder-slate-700">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-widest">Pengeluaran</label>
                                <input type="text" name="pengeluaran" placeholder="2jt" value="<?= $editData['pengeluaran'] ?? '' ?>" required
                                    class="w-full px-4 py-3 rounded-xl border outline-none transition placeholder-slate-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-widest">Pendapatan</label>
                                <input type="text" name="pendapatan" placeholder="5jt" value="<?= $editData['pendapatan'] ?? '' ?>" required
                                    class="w-full px-4 py-3 rounded-xl border outline-none transition placeholder-slate-700">
                            </div>
                        </div>

                        <div class="pt-6 space-y-3">
                            <?php if ($editData): ?>
                                <input type="hidden" name="edit_index" value="<?= $editIndex ?>">
                                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-orange-900/20 transform active:scale-95">
                                    <i class="fas fa-save mr-2"></i> Update Data
                                </button>
                                <a href="alternatif.php" class="block text-center w-full bg-slate-700 hover:bg-slate-600 text-slate-300 font-bold py-4 rounded-2xl transition">
                                    Batal
                                </a>
                            <?php else: ?>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-blue-900/40 transform active:scale-95">
                                    <i class="fas fa-plus mr-2"></i> Simpan Alternatif
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="table-alt rounded-3xl shadow-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-900/50 border-b border-slate-700">
                                <tr>
                                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-[0.2em] text-center w-16">No</th>
                                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Info Alternatif</th>
                                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                <?php if (empty($dataAlternatif)): ?>
                                    <tr>
                                        <td colspan="3" class="px-6 py-20 text-center text-slate-500 italic">
                                            <i class="fas fa-user-slash text-4xl mb-4 block opacity-20"></i>
                                            Belum ada data alternatif yang terdaftar.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($dataAlternatif as $i => $alt): ?>
                                        <tr class="row-hover transition-colors">
                                            <td class="px-6 py-6 text-center text-slate-500 font-mono"><?= $i + 1 ?></td>
                                            <td class="px-6 py-6">
                                                <div class="font-bold text-white text-lg tracking-tight"><?= htmlspecialchars($alt['alternatif']) ?></div>
                                                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2">
                                                    <span class="text-xs text-slate-400 flex items-center"><i class="fas fa-shield-alt mr-1.5 text-blue-500/50"></i> <?= htmlspecialchars($alt['jaminan']) ?></span>
                                                    <span class="text-xs text-slate-400 flex items-center"><i class="fas fa-clock mr-1.5 text-blue-500/50"></i> <?= htmlspecialchars($alt['lama_pinjam']) ?></span>
                                                    <span class="text-xs text-slate-400 flex items-center"><i class="fas fa-wallet mr-1.5 text-emerald-500/50"></i> Rp<?= htmlspecialchars($alt['pendapatan']) ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-6 text-center">
                                                <div class="flex justify-center space-x-3">
                                                    <a href="alternatif.php?edit=<?= $i ?>" class="w-10 h-10 flex items-center justify-center bg-blue-500/10 text-blue-400 rounded-xl hover:bg-blue-500 hover:text-white transition-all shadow-lg shadow-blue-900/10" title="Edit">
                                                        <i class="fas fa-edit text-sm"></i>
                                                    </a>
                                                    <a href="alternatif.php?delete=<?= $i ?>" onclick="return confirm('Hapus data ini?')"
                                                        class="w-10 h-10 flex items-center justify-center bg-red-500/10 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-lg shadow-red-900/10" title="Hapus">
                                                        <i class="fas fa-trash-alt text-sm"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <a href="tabel_kriteria.php" class="text-slate-400 hover:text-white font-bold transition flex items-center group">
                        <i class="fas fa-arrow-left mr-3 transition-transform group-hover:-translate-x-1"></i> Kembali ke Kriteria
                    </a>
                    <?php if (!empty($dataAlternatif)): ?>
                        <a href="matrik_kriteria.php" class="px-10 py-4 bg-emerald-600 text-white font-black rounded-2xl hover:bg-emerald-500 shadow-[0_10px_20px_-5px_rgba(16,185,129,0.3)] transition-all transform hover:-translate-y-1 active:scale-95 flex items-center">
                            Lanjut ke Matriks Kriteria <i class="fas fa-chevron-right ml-3 text-xs"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

</body>

</html>