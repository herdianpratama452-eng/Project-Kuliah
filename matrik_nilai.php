<?php
session_start();

// Nama kriteria
$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);

// Ambil matriks perbandingan dari session (atau gunakan contoh perhitungan)
$matrik = $_SESSION['matrikKriteria'] ?? [
    // contoh sesuai pertanyaan
    [1, 2, 3, 4, 5],   // Jaminan
    [0.5, 1, 2, 3, 4], // Lama Pinjam
    [0.33, 0.5, 1, 2, 3],  // Kegunaan
    [0.25, 0.33, 0.5, 1, 2], // Pengeluaran
    [0.2, 0.25, 0.33, 0.5, 1] // Pendapatan
];

// Hitung jumlah tiap kolom
$jumlahKolom = [];
for ($j = 0; $j < $n; $j++) {
    $jumlahKolom[$j] = 0;
    for ($i = 0; $i < $n; $i++) {
        $jumlahKolom[$j] += $matrik[$i][$j];
    }
}

// Hitung matriks normalisasi
$matrikNorm = [];
for ($i = 0; $i < $n; $i++) {
    for ($j = 0; $j < $n; $j++) {
        $matrikNorm[$i][$j] = round($matrik[$i][$j] / $jumlahKolom[$j], 2);
    }
}

// Hitung rata-rata tiap baris (priority vector)
$priority = [];
for ($i = 0; $i < $n; $i++) {
    $priority[$i] = round(array_sum($matrikNorm[$i]) / $n, 2);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Matriks Nilai Kriteria</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 20px auto;
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
    <h2 style="text-align:center;">Matriks Normalisasi / Nilai Kriteria</h2>

    <table>
        <tr>
            <th>Kriteria</th>
            <?php foreach ($kriteria as $k): ?>
                <th><?= $k ?></th>
            <?php endforeach; ?>
            <th>Rata-rata</th>
        </tr>

        <?php for ($i = 0; $i < $n; $i++): ?>
            <tr>
                <td><?= $kriteria[$i] ?></td>
                <?php for ($j = 0; $j < $n; $j++): ?>
                    <td>
                        <?= $matrikNorm[$i][$j] ?>
                        <br><small>(<?= $matrik[$i][$j] ?> / <?= round($jumlahKolom[$j], 2) ?>)</small>
                    </td>
                <?php endfor; ?>
                <td><strong><?= $priority[$i] ?></strong></td>
            </tr>
        <?php endfor; ?>
    </table>

    <p style="text-align:center;"><a href="matrik_kriteria.php">⬅ Kembali ke Matriks Perbandingan Kriteria</a></p>

</body>

</html>