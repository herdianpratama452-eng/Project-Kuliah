<?php
session_start();

// Daftar kriteria
$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);

// Ambil matriks perbandingan & prioritas dari session
$matrik = $_SESSION['matrikKriteria'] ?? [];
$prioritas = $_SESSION['prioritas'] ?? [];

if (empty($matrik) || empty($prioritas)) {
    echo "<p style='text-align:center;color:red;'>Data belum lengkap! Hitung bobot prioritas dulu.</p>";
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

// Format rumus CI untuk ditampilkan
$rumus_CI =
    "(" . round($lambdaMax, 2) . " - " . $n . ") / (" . $n . " - 1) = "
    . round($selisih, 2) . " / " . $penyebut
    . " = " . round($CI, 2);

// ==========================
// Hitung CR
// ==========================
$RI_table = [1 => 0, 2 => 0, 3 => 0.58, 4 => 0.90, 5 => 1.12];
$RI = $RI_table[$n];

$CR = ($RI == 0 ? 0 : $CI / $RI);

// Rumus CR untuk ditampilkan
$rumus_CR =
    round($CI, 2) . " / " . $RI .
    " = " . round($CR, 4);

$status = ($CR < 0.1 ? "Konsisten ✔" : "Tidak Konsisten ❌");

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
            width: 85%;
            text-align: center;
            font-family: Arial;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #333;
        }

        th {
            background: #f5f5f5;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">Tabel Perhitungan Rasio Konsistensi</h2>

    <table>
        <tr>
            <th>Kriteria</th>
            <th>Jumlah Kolom</th>
            <th>Bobot (wᵢ)</th>
            <th>λᵢ</th>
        </tr>

        <?php for ($i = 0; $i < $n; $i++): ?>
            <tr>
                <td><?= $kriteria[$i] ?></td>
                <td><?= round($colSum[$i], 3) ?></td>
                <td><?= round($prioritas[$i], 4) ?></td>
                <td><?= round($lambda_i[$i], 4) ?></td>
            </tr>
        <?php endfor; ?>

        <tr>
            <th colspan="3">λ maks</th>
            <td><?= round($lambdaMax, 4) ?></td>
        </tr>

        <tr>
            <th colspan="3">CI (Detail Rumus)</th>
            <td><?= $rumus_CI ?></td>
        </tr>

        <tr>
            <th colspan="3">RI</th>
            <td><?= $RI ?></td>
        </tr>

        <tr>
            <th colspan="3">CR (Detail Rumus)</th>
            <td><?= $rumus_CR ?> (<?= $status ?>)</td>
        </tr>

    </table>

    <br>
    <p style="text-align:center;">
        <a href="Perhitungan skor setiap alternatif.php"
            style="padding:10px 15px; background:green; color:white; text-decoration:none;">
            ➡ Lanjut ke Perhitungan Skor Setiap Alternatif
        </a>