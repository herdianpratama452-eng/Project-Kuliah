<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    if (isset($_POST['kriteria']) && isset($_POST['sub_kriteria'])) {
        foreach ($_POST['kriteria'] as $index => $kriteria_nama) {
            $k = trim($kriteria_nama);
            if ($k === '') continue;

            $subs = [];
            if (isset($_POST['sub_kriteria'][$index])) {
                foreach ($_POST['sub_kriteria'][$index] as $sub) {
                    $sub_trim = trim($sub);
                    if ($sub_trim !== '') {
                        $subs[] = $sub_trim;
                    }
                }
            }

            if (!empty($subs)) {
                $data[] = [
                    'kriteria' => $k,
                    'sub_kriteria' => $subs
                ];
            }
        }
    }

    $_SESSION['dataKriteria'] = $data;
    header("Location: tabel_kriteria.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kriteria - Navy Dark</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Navy Dark Palette */
        body {
            background-color: #0f172a;
            /* Slate 900 */
            color: #f1f5f9;
        }

        .kriteria-card {
            background-color: #1e293b;
            /* Slate 800 */
            border: 1px solid #334155;
            /* Slate 700 */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .kriteria-card:hover {
            border-color: #60a5fa;
            /* Blue 400 */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
        }

        input[type="text"] {
            background-color: #0f172a;
            border-color: #334155;
            color: #f8fafc;
        }

        input[type="text"]:focus {
            background-color: #1e293b;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .fade-in-up {
            animation: fadeInUp 0.4s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="py-12 px-4 bg-gradient-to-br from-[#0f172a] via-[#111827] to-[#000000] min-h-screen">

    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-black text-white tracking-tight mb-3">Manajemen Kriteria</h2>
            <p class="text-slate-400 font-medium italic">Rancang kriteria penilaian Anda dalam tampilan Navy yang elegan.</p>
        </div>

        <form method="POST" action="">
            <div id="kriteriaContainer" class="space-y-8">

                <div class="kriteria-card rounded-3xl p-8 relative shadow-2xl">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="bg-blue-500/10 text-blue-400 p-3 rounded-2xl mr-4 border border-blue-500/20">
                                <i class="fas fa-list-ul"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-100 tracking-wide">Kriteria Utama</h3>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-[0.2em]">Nama Kriteria</label>
                        <input type="text" name="kriteria[]" required
                            class="w-full px-5 py-3.5 rounded-2xl border outline-none transition placeholder-slate-600"
                            placeholder="Contoh: Pengalaman Kerja">
                    </div>

                    <div class="mb-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-[0.2em]">Sub Kriteria</label>
                        <div class="sub-container space-y-3">
                            <input type="text" name="sub_kriteria[0][]" required
                                class="w-full px-5 py-3.5 rounded-2xl border outline-none transition placeholder-slate-700 font-light"
                                placeholder="Masukkan sub kriteria...">
                        </div>
                        <button type="button"
                            class="mt-5 text-sm flex items-center text-blue-400 hover:text-blue-300 font-semibold transition group"
                            data-sub-name="sub_kriteria[0][]" onclick="tambahSub(this)">
                            <i class="fas fa-plus-circle mr-2 transition-transform group-hover:rotate-90"></i> Tambah Sub Kriteria
                        </button>
                    </div>
                </div>

            </div>

            <div class="mt-12 flex flex-col sm:flex-row gap-5 items-center justify-center">
                <button type="button" onclick="tambahKriteria()"
                    class="w-full sm:w-auto px-8 py-4 bg-slate-800/50 border border-slate-700 text-slate-300 rounded-2xl hover:bg-slate-800 hover:text-white font-bold transition flex items-center justify-center">
                    <i class="fas fa-plus mr-3 text-xs"></i> Tambah Kriteria
                </button>

                <button type="submit"
                    class="w-full sm:w-auto px-14 py-4 bg-blue-600 text-white rounded-2xl hover:bg-blue-500 shadow-[0_10px_20px_-5px_rgba(37,99,235,0.4)] font-bold transition flex items-center justify-center transform active:scale-95">
                    <i class="fas fa-check-circle mr-3"></i> Simpan Data Kriteria
                </button>
            </div>
        </form>
    </div>

    <script>
        function tambahSub(button) {
            const container = button.previousElementSibling;
            const input = document.createElement('input');
            input.type = 'text';
            input.name = button.getAttribute('data-sub-name');
            input.placeholder = 'Sub kriteria baru...';
            input.className = 'w-full px-5 py-3.5 border border-slate-700 rounded-2xl bg-[#0f172a] text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition mb-3 fade-in-up font-light';
            container.appendChild(input);
        }

        function tambahKriteria() {
            const container = document.getElementById('kriteriaContainer');
            const index = Date.now();
            const div = document.createElement('div');
            div.className = 'kriteria-card rounded-3xl p-8 relative shadow-2xl fade-in-up';

            div.innerHTML = `
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <div class="bg-indigo-500/10 text-indigo-400 p-3 rounded-2xl mr-4 border border-indigo-500/20">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-100 tracking-wide">Kriteria Tambahan</h3>
                    </div>
                    <button type="button" onclick="hapusKriteria(this)" 
                            class="text-slate-500 hover:text-red-400 transition-colors p-2" title="Hapus">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-[0.2em]">Nama Kriteria</label>
                    <input type="text" name="kriteria[]" required 
                           class="w-full px-5 py-3.5 rounded-2xl border outline-none transition placeholder-slate-600" 
                           placeholder="Nama kriteria...">
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-[0.2em]">Sub Kriteria</label>
                    <div class="sub-container space-y-3">
                        <input type="text" name="sub_kriteria[${index}][]" required 
                               class="w-full px-5 py-3.5 rounded-2xl border outline-none transition placeholder-slate-700 font-light" 
                               placeholder="Masukkan sub kriteria...">
                    </div>
                    <button type="button" 
                            class="mt-5 text-sm flex items-center text-blue-400 hover:text-blue-300 font-semibold transition group" 
                            data-sub-name="sub_kriteria[${index}][]" onclick="tambahSub(this)">
                        <i class="fas fa-plus-circle mr-2 transition-transform group-hover:rotate-90"></i> Tambah Sub Kriteria
                    </button>
                </div>
            `;
            container.appendChild(div);
        }

        function hapusKriteria(button) {
            const card = button.closest('.kriteria-card');
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95) translateY(10px)';
            setTimeout(() => {
                card.remove();
            }, 300);
        }
    </script>
</body>

</html>