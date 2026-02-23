<?php
session_start();

// Daftar kriteria
$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);

// Ambil matriks dan bobot prioritas
$matrik = $_SESSION['matrikKriteria'] ?? [];
$prioritas = $_SESSION['prioritas'] ?? [];

if (empty($matrik) || empty($prioritas)) {
    echo "<p style='text-align:center; color:red;'>Matriks kriteria atau bobot prioritas belum tersedia. 
    <a href='prioritas_kriteria.php'>Kembali</a></p>";
    exit;
}

// ===== Hitung Aw_i =====
$Aw = [];
for ($i = 0; $i < $n; $i++) {
    $Aw[$i] = 0;
    for ($j = 0; $j < $n; $j++) {
        $Aw[$i] += $matrik[$i][$j] * $prioritas[$j];
    }
}

// ===== Hitung λ_i =====
$lambda_i = [];
for ($i = 0; $i < $n; $i++) {
    $lambda_i[$i] = $Aw[$i] / $prioritas[$i];
}

// ===== Hitung λmaks =====
$lambdaMax = array_sum($lambda_i) / $n;

// ===== Hitung CI dan CR =====
$CI = ($lambdaMax - $n) / ($n - 1);
$RI_table = [1 => 0, 2 => 0, 3 => 0.58, 4 => 0.90, 5 => 1.12];
$RI = $RI_table[$n];
$CR = $RI == 0 ? 0 : $CI / $RI;

$status = $CR < 0.1 ? "Konsisten ✔" : "Tidak Konsisten ❌";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Perhitungan Rasio Konsistensi</title>
    <style>
        table {
            border-collapse: collapse;
            margin: auto;
            text-align: center;
            font-family: Arial;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }

        .btn-nav {
            display: inline-block;
            padding: 10px 18px;
            text-decoration: none;
            background: #17a2b8;
            color: white;
            border-radius: 6px;
            font-size: 18px;
        }

        .btn-nav:hover {
            background: #138496;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">Tabel Perhitungan Rasio Konsistensi (CR)</h2>

    <table>
        <tr>
            <th>Kriteria</th>
            <th>Aw_i = Σ(a_ij × w_j)</th>
            <th>w_i (Bobot)</th>
            <th>λ_i = Aw_i / w_i</th>
        </tr>

        <?php for ($i = 0; $i < $n; $i++): ?>
            <tr>
                <td><?= $kriteria[$i] ?></td>
                <td><?= round($Aw[$i], 4) ?></td>
                <td><?= round($prioritas[$i], 4) ?></td>
                <td><?= round($lambda_i[$i], 4) ?></td>
            </tr>
        <?php endfor; ?>

        <tr>
            <th colspan="3">λ maks</th>
            <td><?= round($lambdaMax, 4) ?></td>
        </tr>
        <tr>
            <th colspan="3">Consistency Index (CI)</th>
            <td><?= round($CI, 4) ?></td>
        </tr>
        <tr>
            <th colspan="3">Random Index (RI)</th>
            <td><?= $RI ?></td>
        </tr>
        <tr>
            <th colspan="3">Consistency Ratio (CR)</th>
            <td><?= round($CR, 4) ?> (<?= $status ?>)</td>
        </tr>
    </table>

    <br>

    <p style="text-align:center; margin-top:20px;">
        <a href="Menghitung Bobot Prioritas Kriteria.php">⬅ Kembali ke Bobot Prioritas</a> |
        <a href="alternatif.php">➡ Masukkan Data Alternatif</a>
    </p>

    <?php if ($CR < 0.1): ?>
        <!-- === Tombol Ikon Lanjut ke Skor Alternatif === -->
        <p style="text-align:center; margin-top:25px;">
            <a href="skor alternatif.php" class="btn-nav">📊 Lanjut ke Skor Alternatif</a>
        </p>
    <?php endif; ?>

</body>

</html>