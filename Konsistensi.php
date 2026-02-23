<?php
session_start();

$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);

// Ambil matriks perbandingan dan prioritas dari session
$matrik = $_SESSION['matrikKriteria'] ?? [];
$prioritas = $_SESSION['prioritas'] ?? [];

// Jika prioritas belum dihitung, hitung otomatis
if (empty($prioritas) && !empty($matrik)) {
    // Normalisasi matriks
    $jumlahKolom = [];
    for ($j = 0; $j < $n; $j++) {
        $jumlahKolom[$j] = 0;
        for ($i = 0; $i < $n; $i++) {
            $jumlahKolom[$j] += $matrik[$i][$j];
        }
    }
    $matrikNorm = [];
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $matrikNorm[$i][$j] = $matrik[$i][$j] / $jumlahKolom[$j];
        }
    }
    // Prioritas
    $prioritas = [];
    for ($i = 0; $i < $n; $i++) {
        $prioritas[$i] = array_sum($matrikNorm[$i]) / $n;
    }
}

// Hitung Aw
$Aw = [];
for ($i = 0; $i < $n; $i++) {
    $Aw[$i] = 0;
    for ($j = 0; $j < $n; $j++) {
        $Aw[$i] += $matrik[$i][$j] * $prioritas[$j];
    }
}

// Hitung lambda max
$lambdaMaxArr = [];
for ($i = 0; $i < $n; $i++) {
    $lambdaMaxArr[$i] = $Aw[$i] / $prioritas[$i];
}
$lambdaMax = array_sum($lambdaMaxArr) / $n;

// CI
$CI = ($lambdaMax - $n) / ($n - 1);

// RI tabel
$RI_table = [1 => 0, 2 => 0, 3 => 0.58, 4 => 0.90, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45, 10 => 1.49];
$RI = $RI_table[$n] ?? 1.49;

// CR
$CR = $RI == 0 ? 0 : $CI / $RI;
$status = $CR < 0.1 ? "Konsisten ✔" : "Tidak Konsisten ❌";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rasio Konsistensi Kriteria</title>
    <style>
        table {
            border-collapse: collapse;
            margin: auto;
            text-align: center;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">Tabel Rasio Konsistensi Kriteria</h2>

    <table>
        <tr>
            <th>Langkah</th>
            <th>Rumus / Penjelasan</th>
            <th>Nilai</th>
        </tr>

        <tr>
            <td>&lambda; Maks</td>
            <td>Rata-rata (Aw_i / w_i)</td>
            <td><?= round($lambdaMax, 2) ?></td>
        </tr>

        <tr>
            <td>Consistency Index (CI)</td>
            <td>(λ maks - n) / (n-1)</td>
            <td><?= round($CI, 2) ?></td>
        </tr>

        <tr>
            <td>Random Index (RI)</td>
            <td>Nilai RI dari tabel</td>
            <td><?= $RI ?></td>
        </tr>

        <tr>
            <td>Consistency Ratio (CR)</td>
            <td>CI / RI</td>
            <td><?= round($CR, 2) ?> (<?= $status ?>)</td>
        </tr>
    </table>

    <p style="text-align:center; margin-top:10px;">
        <a href="prioritas_kriteria.php">⬅ Kembali ke Bobot Prioritas</a>
    </p>

</body>

</html>