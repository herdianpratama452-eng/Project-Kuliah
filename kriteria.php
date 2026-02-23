<?php
session_start();

// Data kriteria dari session (atau kosong jika belum diset)
$dataKriteria = $_SESSION['dataKriteria'] ?? [];

// Contoh data tabel 2, misalnya penilaian bobot kriteria
$dataPenilaian = [
    ['Kriteria' => 'Jaminan', 'Bobot' => 0.3],
    ['Kriteria' => 'Lama Pinjam', 'Bobot' => 0.25],
    ['Kriteria' => 'Kegunaan', 'Bobot' => 0.2],
    ['Kriteria' => 'Pengeluaran', 'Bobot' => 0.15],
    ['Kriteria' => 'Pendapatan', 'Bobot' => 0.1],
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Kriteria & Penilaian</title>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
            margin: 20px auto;
            font-family: "Times New Roman";
            text-align: center;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
        }

        caption {
            font-weight: bold;
            margin-bottom: 8px;
        }
    </style>
</head>

<body>

    <!-- Tabel 1: Data Kriteria -->
    <table>
        <caption>Tabel 1. Data Kriteria</caption>
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Sub Kriteria</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($dataKriteria)): ?>
                <tr>
                    <td colspan="2">Data belum tersedia</td>
                </tr>
            <?php else: ?>
                <?php foreach ($dataKriteria as $item): ?>
                    <?php $subCount = count($item['sub_kriteria']); ?>
                    <?php foreach ($item['sub_kriteria'] as $index => $sub): ?>
                        <tr>
                            <?php if ($index === 0): ?>
                                <td rowspan="<?= $subCount ?>"><?= htmlspecialchars($item['kriteria']) ?></td>
                            <?php endif; ?>
                            <td><?= htmlspecialchars($sub) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tabel 2: Data Penilaian -->
    <table>
        <caption>Tabel 2. Data Penilaian Bobot</caption>
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Bobot</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataPenilaian as $penilaian): ?>
                <tr>
                    <td><?= htmlspecialchars($penilaian['Kriteria']) ?></td>
                    <td><?= htmlspecialchars($penilaian['Bobot']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>